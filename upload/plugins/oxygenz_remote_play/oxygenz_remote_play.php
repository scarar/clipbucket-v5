<?php
/*
	Plugin Name: Oxygenz - Remote Play
	Description: Allow to add external videos from URL
	Author: Oxygenz
    Author Website: https://oxygenz.fr
    Version: 1.0.2
	ClipBucket Version: 5.5.0
	Website: https://github.com/MacWarrior/clipbucket-v5/
*/

class oxygenz_remote_play {
    static $template_dir = PLUG_DIR.DIRECTORY_SEPARATOR.self::class.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR;
    static $media_dir = DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR;
    static $js_dir = DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR;
    static $lang_prefix = 'plugin_'.self::class.'_';

    /**
     * @throws Exception
     */
    function __construct(){
        $this->add_upload_form();
        $this->add_js();
        $this->register_custom_upload_field();
        $this->register_custom_video_file_funcs();
    }

    /**
     * @throws Exception
     */
    private function add_upload_form(){
        global $Cbucket;

        $Cbucket->upload_opt_list['link_video_link'] = [
            'title'      => lang(self::$lang_prefix.'remote_play'),
            'class'      => self::class,
            'function'   => 'load_form'
        ];
    }

    private function add_js(){
        if( defined('THIS_PAGE') && THIS_PAGE != 'upload' ){
            return;
        }

        $js_file = self::class.'.min.js';
        if(in_dev()){
            $js_file =  self::class.'.js';
        }
        add_js([self::class.'/js/'.$js_file => 'plugin']);

        global $Cbucket;
        $Cbucket->add_header(PLUG_DIR . DIRECTORY_SEPARATOR.self::class.self::$js_dir.'header.html');
    }

    /**
     * @throws Exception
     */
    private function register_custom_upload_field()
    {
        $link_vid_field_array['remote_play_url'] = [
            'title'		        => lang(self::$lang_prefix.'input_url'),
            'name'		        => 'remote_play_url',
            'db_field'	        => 'remote_play_url',
            'required'	        => 'no',
            'validate_function' => self::class.'::isValidVideoURL',
            'use_func_val'      => true,
            'type'	            => 'textfield',
            'use_if_value'      => true
        ];

        register_custom_upload_field($link_vid_field_array);
    }

    private function register_custom_video_file_funcs(){
        register_custom_video_file_func('get_video_url', self::class);
    }

    /**
     * @throws Exception
     */
    public static function load_form()
    {
        $plugin_cb_link_video_input_url_example = sprintf( lang(self::$lang_prefix.'input_url_example'), BASEURL.PLUG_URL.self::$media_dir.'example.mp4' );
        assign('placeholder_url', $plugin_cb_link_video_input_url_example);
        Template(self::$template_dir.'first-form.html', false);
    }

    public static function isValidVideoURL($video_url){
        if (filter_var($video_url, FILTER_VALIDATE_URL) === FALSE) {
            return false;
        }

        $extension = strtolower(getExt($video_url));
        $allowed_extensions = ['mp4','m3u8'];
        if( !in_array($extension, $allowed_extensions) ){
            return false;
        }

        $check_url = get_headers($video_url);
        if( !isset($check_url[0]) ){
            return false;
        }

        if( strpos($check_url[0], '200') === false ){
            return false;
        }

        return $video_url;
    }

    public static function get_video_url($vdetails, $hq = false)
    {
        if( !empty($vdetails['remote_play_url']) ) {
            return $vdetails['remote_play_url'];
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public static function process_file($video_url, $video_id){
        require_once(dirname(__DIR__, 2) . '/includes/classes/sLog.php');
        require_once(dirname(__DIR__, 2) . '/includes/classes/conversion/ffmpeg.class.php');

        $file_directory = create_dated_folder();
        $vdetails = get_video_details($video_id);
        $logFile = LOGS_DIR . DIRECTORY_SEPARATOR . $file_directory . DIRECTORY_SEPARATOR . $vdetails['file_name'] . '.log';

        $log = new SLog($logFile);
        $ffmpeg = new FFMpeg($log);

        $ffmpeg->log->newSection('Conversion lock');
        while($ffmpeg->isLocked()){
            $ffmpeg->log->writeLine(date('Y-m-d H:i:s').' - Waiting for conversion lock...');
            sleep(5);
        }
        $ffmpeg->log->writeLine(date('Y-m-d H:i:s').' - Starting conversion...');

        $video_infos = $ffmpeg->get_file_info($video_url);
        update_video_status($vdetails['file_name'], 'Processing');
        $ffmpeg->input_details['video_width'] = $video_infos['video_width'];
        $ffmpeg->input_details['video_height'] = $video_infos['video_height'];
        $resolutions = $ffmpeg->get_eligible_resolutions();
        $max_resolution = '';
        foreach($resolutions as $res){
            if( $res['height'] > $max_resolution ){
                $max_resolution =  $res['height'];
            }
        }

        $ffmpeg->file_name = $vdetails['file_name'];
        $ffmpeg->input_file = $video_url;
        $ffmpeg->file_directory = $file_directory.DIRECTORY_SEPARATOR;
        $ffmpeg->extract_subtitles();

        $ffmpeg->input_details['duration'] = $video_infos['duration'];
        $ffmpeg->generateAllThumbs();

        $fields = [
            'duration' => $video_infos['duration']
            ,'file_type' => getExt($video_url)
            ,'video_files' => '['.$max_resolution.']'
            ,'bits_color' => $video_infos['bits_per_raw_sample']
            ,'file_directory' => $file_directory
            ,'is_castable' => $video_infos['audio_channels'] <= 2 ? '1' : '0'
            ,'status' => 'Successful'
        ];

        global $db;
        $db->update(tbl('video'), array_keys($fields), array_values($fields), ' videoid = \''.$video_id.'\'');

        $ffmpeg->unLock();

        $ffmpeg->log->newSection('<b>Conversion Completed</b>');
    }

}

new oxygenz_remote_play();
