# ClipBucket V5 - An updated way to broadcast yourself
<a href="https://github.com/MacWarrior/clipbucket-v5">ClipBucket V5</a> is a __free updated and upgraded__ version of <a href="https://github.com/arslancb/clipbucket">ClipBucket</a>.

ClipBucket is an Open Source and freely downloadable PHP script that will let you start your own Video Sharing website (YouTube Clone) in a matter of minutes. ClipBucket is the fastest growing video script with the most advanced video sharing and social features.

With ClipBucket, you will have almost all social media features in your hand. You can let your users create groups, playlists, collections and much more. They can send friend requests and private messages to each other as well.
You can start a fully dedicated video sharing website or photo sharing websites and also both at the same time as well.
<br/><br/>

<p align="center">
  <img src="./upload/images/screenshot.jpg"/>
</p>

# Update 5.5.0
After more than 370 revisions, we're proud to officialy announce the release of ClipBucketV5 - 5.5.0, the biggest update of ClipBucket to this day, implementing tons of new features and preparing it's future.
<p align="center">
    <a href="https://github.com/MacWarrior/clipbucket-v5/releases/tag/5.5.0">
      <img src="./upload/images/release-5.5.0.png" alt="ClipbucketV5 update 5.5.0 features list"/>
    </a>
</p>

# History
ClipBucket <a href="https://github.com/arslancb/clipbucket">original repository</a> has been slowly dying since the release 4.1 (May 2018) and has been archived on December 2022.<br/>
<a href="https://github.com/MacWarrior/clipbucket-v5">ClipBucket V5</a> was created on 2016 by <a href="https://github.com/MacWarrior">MacWarrior</a> and is part of <a href="https://clipbucket.oxygenz.fr/en/" target="_blank">Oxygenz</a>'s projects since 2023

# Why <a href="https://github.com/MacWarrior/clipbucket-v5">ClipBucket V5</a>
| PHP 7.0 - 8.4+ compatibility                                      | MySQL 9+ & strict mode compatibility                      |
|-------------------------------------------------------------------|-----------------------------------------------------------|
| UHD video resolutions support                                     | TMDB integration                                          |
| Dark & Light theme                                                | Age restriction                                           |
| Chromecast support                                                | Recursive collections                                     |
| Subtitles support                                                 | HLS conversion                                            |
| Visual comments editor                                            | New configuration & personalisation options               |
| Easy installation scripts                                         | Updated libraries <i>(VideoJS, Smarty, amCharts, ...)</i> |
| Integrated DB update system                                       | Integrated translations <i>(ENG, FRA, DEU, POR, ESP)</i>  |
| <b>Security, performance, stability and codestyle improvements<b> |                                                           |

And even more !

# Installation
### Beginners
Greetings young adventurer ! Don't worry, we've thought about you and created some easy installation scripts !<br/>
All you need is here : <a href="https://github.com/MacWarrior/clipbucket-v5/tree/master/utils">Installation scripts</a><br/>
<i>It should also be noted that these scripts are meant for testing and development purposes only</i>

## Installation with Docker
Installing <a href="https://github.com/MacWarrior/clipbucket-v5">ClipBucket V5</a> using Docker provides a streamlined and isolated environment for running the application. Here's how you can set it up:

### Step-by-Step Installation Guide:
**Run the ClipBucket Container From Docker Hub:**
   ```bash
   docker run \
   --restart unless-stopped \
   --pull=always \
   -e DOMAIN_NAME=clipbucket.local \
   -e MYSQL_ROOT_PASSWORD=clipbucket_password \
   -v clipbucket_db:/var/lib/mysql \
   -v clipbucket_files:/srv/http/clipbucket \
   -p 80:80 \
   --name clipbucket \
   -d oxygenz/clipbucket-v5:latest
   ```

### Explanation of Docker Commands:
- **`docker run` options:**
    - `--restart unless-stopped`: Automatically restarts the container unless explicitly stopped.
    - `--pull=always`: Ensures the image is always pulled before starting, even if it exists locally.
    - `-e DOMAIN_NAME=...`: Sets the domain name for your ClipBucket instance.
    - `-e MYSQL_ROOT_PASSWORD=...`: Specifies the root password for MySQL.
    - `-v clipbucket_db:/var/lib/mysql`: Maps a persistent volume for the database.
    - `-v clipbucket_files:/srv/http/clipbucket`: Maps a persistent volume for ClipBucket files.
    - `-p 80:80`: Maps port 80 on the host to port 80 on the container, making the application accessible via the host machine.
    - `--name clipbucket`: Names the container for easier management.
    - `-d`: Runs the container in detached mode.

### Advanced users
<i>“Your path you must decide.”</i><br/>
Required : MySQL 5.6+ / MariaDB 10.3+ ; PHP-FPM 7.0+ (+ modules : mysqli, curl, xml, mbstring, gd, openssl, fileinfo ; + functions exec, shell_exec) ; FFmpeg 3+ ; mediainfo ; sendmail<br/>
Recommended : MariaDB 10.3+ ; PHP 8.3+ ; FFmpeg 4.3+<br/>
Optionnal : Git<br/>
<i>Only stable versions have been tested, mainly on Debian</i>

# DB auto-update system
On version 5.5.0, Revision 169, a new DB update system has been implemented, since then, you can easily update your DB from any version since 4.2 RC1 to any new version/revision.<br/>
Update your sources, log in and follow instructions displayed.

# Updating from ClipBucket 4.2
Follow our [quick steps tutorial](https://github.com/MacWarrior/clipbucket-v5/wiki/Upgrade-from-Clipbucket-4.2)

# Issues
Still reading ? Good !<br/>
Now your <a href="https://github.com/MacWarrior/clipbucket-v5">ClipBucket V5</a> is installed <i>(or maybe not yet)</i> 
and you request some help ? Or found a bug ? Or have a brilliant idea ?<br/>
Take a step back, breath slowly, and create an <a href="https://github.com/MacWarrior/clipbucket-v5/issues">issue</a> !<br/>
Be the more precise you can, add screenshots, give examples... I'm sure we will find a solution !

# More
<a href="https://discord.gg/HDm5CjM">!['Discord'](./upload/images/discord.png "Join us on Discord")</a>
