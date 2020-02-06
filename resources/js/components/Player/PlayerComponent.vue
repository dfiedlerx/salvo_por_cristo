<template>
    <div>
        <div class="player">

            <div class="player__top">
                <div class="player-cover">
                    <transition-group :name="transitionName">
                        <div class="player-cover__item" v-if="$index === currentTrackIndex" :style="{ backgroundImage: `url(${track.cover})` }"  v-for="(track, $index) in tracks" :key="$index"></div>
                    </transition-group>
                </div>
                <div class="player-controls">
                    <div class='icon-player-content'>
                        <div class="player-controls__item -favorite" :class="{ active : currentTrack.favorited }" @click="favorite">
                            <i class="fa fa-heart" aria-hidden="true"></i>
                        </div>
                        <a :href="currentTrack.url" target="_blank" class="player-controls__item">
                            <i class="fa fa-download" aria-hidden="true"></i>
                        </a>
                        <div class="player-controls__item" @click="prevTrack">
                            <i class="fa fa-angle-left" aria-hidden="true"></i>
                        </div>
                        <div class="player-controls__item" @click="nextTrack">
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                        </div>
                        <div>
                            <div class="player-controls__item" @click="changeTime(-10)">
                                <i class="fa fa-minus" aria-hidden="true"></i>
                            </div>
                            <div class="player-controls__item" @click="changeTime(10)">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <div class='icon-player-content'>
                        <div class="player-controls__item -xl js-play" @click="play">
                            <svg class="icon">
                                <use xlink:href="#icon-pause" v-if="isTimerPlaying"></use>
                                <use xlink:href="#icon-play" v-else></use>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div style="position: relative; width: 100%;">
                <div style="position: absolute; right: -1.5%; bottom: -85px;" class="player-controls__item" @click="resetPlayer()">
                    <i class="fa fa-refresh" style="font-size: 20px;" aria-hidden="true"></i>
                </div>
            </div>
            <div class="progress" ref="progress">
                <div class="progress__top">
                    <div class="album-info" v-if="currentTrack">
                        <div class="album-info__name"  v-text="currentTrack.artist"></div>
                        <div class="album-info__track" v-text="currentTrack.name"></div>
                    </div>
                    <div class="progress__duration"  v-text="duration"></div>
                </div>
                <div class="progress__bar" @click="clickProgress">
                    <div class="progress__current" :style="{ width : barWidth }"></div>
                </div>
                <div class="progress__time" v-text="currentTime"></div>
            </div>
            <div v-cloak></div>
        </div>

        <svg xmlns="http://www.w3.org/2000/svg" hidden xmlns:xlink="http://www.w3.org/1999/xlink" style="display: none;">
            <defs>
                <symbol id="icon-pause" viewBox="0 0 32 32">
                    <title>icon-pause</title>
                    <path d="M16 0.32c-8.64 0-15.68 7.040-15.68 15.68s7.040 15.68 15.68 15.68 15.68-7.040 15.68-15.68-7.040-15.68-15.68-15.68zM16 29.216c-7.296 0-13.216-5.92-13.216-13.216s5.92-13.216 13.216-13.216 13.216 5.92 13.216 13.216-5.92 13.216-13.216 13.216z"></path>
                    <path d="M16 32c-8.832 0-16-7.168-16-16s7.168-16 16-16 16 7.168 16 16-7.168 16-16 16zM16 0.672c-8.448 0-15.328 6.88-15.328 15.328s6.88 15.328 15.328 15.328c8.448 0 15.328-6.88 15.328-15.328s-6.88-15.328-15.328-15.328zM16 29.568c-7.488 0-13.568-6.080-13.568-13.568s6.080-13.568 13.568-13.568c7.488 0 13.568 6.080 13.568 13.568s-6.080 13.568-13.568 13.568zM16 3.104c-7.104 0-12.896 5.792-12.896 12.896s5.792 12.896 12.896 12.896c7.104 0 12.896-5.792 12.896-12.896s-5.792-12.896-12.896-12.896z"></path>
                    <path d="M12.16 22.336v0c-0.896 0-1.6-0.704-1.6-1.6v-9.472c0-0.896 0.704-1.6 1.6-1.6v0c0.896 0 1.6 0.704 1.6 1.6v9.504c0 0.864-0.704 1.568-1.6 1.568z"></path>
                    <path d="M19.84 22.336v0c-0.896 0-1.6-0.704-1.6-1.6v-9.472c0-0.896 0.704-1.6 1.6-1.6v0c0.896 0 1.6 0.704 1.6 1.6v9.504c0 0.864-0.704 1.568-1.6 1.568z"></path>
                </symbol>
                <symbol id="icon-play" viewBox="0 0 32 32">
                    <title>icon-play</title>
                    <path d="M21.216 15.168l-7.616-5.088c-0.672-0.416-1.504 0.032-1.504 0.832v10.176c0 0.8 0.896 1.248 1.504 0.832l7.616-5.088c0.576-0.416 0.576-1.248 0-1.664z"></path>
                    <path d="M13.056 22.4c-0.224 0-0.416-0.064-0.608-0.16-0.448-0.224-0.704-0.672-0.704-1.152v-10.176c0-0.48 0.256-0.928 0.672-1.152s0.928-0.224 1.344 0.064l7.616 5.088c0.384 0.256 0.608 0.672 0.608 1.088s-0.224 0.864-0.608 1.088l-7.616 5.088c-0.192 0.16-0.448 0.224-0.704 0.224zM13.056 10.272c-0.096 0-0.224 0.032-0.32 0.064-0.224 0.128-0.352 0.32-0.352 0.576v10.176c0 0.256 0.128 0.48 0.352 0.576 0.224 0.128 0.448 0.096 0.64-0.032l7.616-5.088c0.192-0.128 0.288-0.32 0.288-0.544s-0.096-0.416-0.288-0.544l-7.584-5.088c-0.096-0.064-0.224-0.096-0.352-0.096z"></path>
                    <path d="M16 0.32c-8.64 0-15.68 7.040-15.68 15.68s7.040 15.68 15.68 15.68 15.68-7.040 15.68-15.68-7.040-15.68-15.68-15.68zM16 29.216c-7.296 0-13.216-5.92-13.216-13.216s5.92-13.216 13.216-13.216 13.216 5.92 13.216 13.216-5.92 13.216-13.216 13.216z"></path>
                    <path d="M16 32c-8.832 0-16-7.168-16-16s7.168-16 16-16 16 7.168 16 16-7.168 16-16 16zM16 0.672c-8.448 0-15.328 6.88-15.328 15.328s6.88 15.328 15.328 15.328c8.448 0 15.328-6.88 15.328-15.328s-6.88-15.328-15.328-15.328zM16 29.568c-7.488 0-13.568-6.080-13.568-13.568s6.080-13.568 13.568-13.568c7.488 0 13.568 6.080 13.568 13.568s-6.080 13.568-13.568 13.568zM16 3.104c-7.104 0-12.896 5.792-12.896 12.896s5.792 12.896 12.896 12.896c7.104 0 12.896-5.792 12.896-12.896s-5.792-12.896-12.896-12.896z"></path>
                </symbol>
            </defs>
        </svg>
    </div>


</template>

<style scopped>
    body {
        background: #dfe7ef;
        font-family: "Bitter", serif;
    }

    * {
        box-sizing: border-box;
    }

    .icon {
        display: inline-block;
        width: 1em;
        height: 1em;
        stroke-width: 0;
        stroke: currentColor;
        fill: currentColor;
    }

    .wrapper {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background-size: cover;
    }
    @media screen and (max-width: 700px), (max-height: 500px) {
        .wrapper {
            flex-wrap: wrap;
            flex-direction: column;
        }
    }

    .player {
        background: #eef3f7;
        width: 410px;
        min-height: 480px;
        box-shadow: 0px 15px 35px -5px rgba(50, 88, 130, 0.32);
        border-radius: 15px;
        padding: 30px;
    }
    @media screen and (max-width: 576px), (max-height: 500px) {
        .player {
            width: 95%;
            padding: 20px;
            margin-top: 50px;
            min-height: initial;
            padding-bottom: 30px;
            max-width: 400px;
        }
    }
    .player__top {
        display: flex;
        align-items: flex-start;
        position: relative;
        z-index: 4;
    }
    @media screen and (max-width: 576px), (max-height: 500px) {
        .player__top {
            flex-wrap: wrap;
        }
    }
    .player-cover {
        width: 300px;
        height: 300px;
        margin-left: -70px;
        flex-shrink: 0;
        position: relative;
        z-index: 2;
        border-radius: 15px;
        z-index: 1;
    }
    @media screen and (max-width: 576px), (max-height: 500px) {
        .player-cover {
            width: 290px;
            height: 230px;
            margin: -70px auto 25px;
        }
    }
    .player-cover__item {
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        width: 100%;
        height: 100%;
        border-radius: 15px;
        position: absolute;
        left: 0;
        top: 0;
    }
    .player-cover__item:before {
        content: "";
        background: inherit;
        width: 100%;
        height: 100%;
        box-shadow: 0px 10px 40px 0px rgba(76, 70, 124, 0.5);
        display: block;
        z-index: 1;
        position: absolute;
        top: 30px;
        transform: scale(0.9);
        filter: blur(10px);
        opacity: 0.9;
        border-radius: 15px;
    }
    .player-cover__item:after {
        content: "";
        background: inherit;
        width: 100%;
        height: 100%;
        box-shadow: 0px 10px 40px 0px rgba(76, 70, 124, 0.5);
        display: block;
        z-index: 2;
        position: absolute;
        border-radius: 15px;
    }
    .player-cover__img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 15px;
        box-shadow: 0px 10px 40px 0px rgba(76, 70, 124, 0.5);
        user-select: none;
        pointer-events: none;
    }
    .player-controls {
        flex: 1;
        padding-left: 20px;
        /*display: flex;
        flex-direction: column;*/
        align-items: center;
    }
    @media screen and (max-width: 576px), (max-height: 500px) {
        .player-controls {
            flex-direction: row;
            padding-left: 0;
            width: 100%;
            flex: unset;
        }
    }
    .player-controls__item {
        display: inline-flex;
        font-size: 30px;
        padding: 5px;
        margin-bottom: 10px;
        color: #acb8cc;
        cursor: pointer;
        width: 50px;
        height: 50px;
        align-items: center;
        justify-content: center;
        position: relative;
        transition: all 0.3s ease-in-out;
    }
    @media screen and (max-width: 576px), (max-height: 500px) {
        .player-controls__item {
            font-size: 26px;
            padding: 5px;
            margin-right: 10px;
            color: #acb8cc;
            cursor: pointer;
            width: 40px;
            height: 40px;
            margin-bottom: 0;
        }
    }
    .player-controls__item::before {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: #fff;
        transform: scale(0.5);
        opacity: 0;
        box-shadow: 0px 5px 10px 0px rgba(76, 70, 124, 0.2);
        transition: all 0.3s ease-in-out;
        transition: all 0.4s cubic-bezier(0.35, 0.57, 0.13, 0.88);
    }
    @media screen and (min-width: 500px) {
        .player-controls__item:hover {
            color: #532ab9;
        }
        .player-controls__item:hover::before {
            opacity: 1;
            transform: scale(1.3);
        }
    }
    @media screen and (max-width: 576px), (max-height: 500px) {
        .player-controls__item:active {
            color: #532ab9;
        }
        .player-controls__item:active::before {
            opacity: 1;
            transform: scale(1.3);
        }
    }
    .player-controls__item .icon {
        position: relative;
        z-index: 2;
    }
    .player-controls__item.-xl {
        margin-bottom: 0;
        font-size: 95px;
        filter: drop-shadow(0 11px 6px rgba(172, 184, 204, 0.45));
        color: #532ab9;
        width: auto;
        height: auto;
        display: inline-flex;
    }
    .player-controls__item.-xl:hover {
        color: #41248c;
    }
    @media screen and (max-width: 576px), (max-height: 500px) {
        .player-controls__item.-xl {
            margin-left: auto;
            font-size: 75px;
            margin-right: 0;
        }
    }
    .player-controls__item.-xl:before {
        display: none;
    }
    .player-controls__item.-favorite.active {
        color: #532ab9;
    }

    [v-cloak] {
        display: none;
    }

    [v-cloak] > * {
        display: none;
    }

    .progress {
        width: 100%;
        margin-top: -15px;
        user-select: none;
    }
    .progress__top {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
    }
    .progress__duration {
        color: #71829e;
        font-weight: 700;
        font-size: 20px;
        opacity: 0.5;
    }
    .progress__time {
        margin-top: 2px;
        color: #71829e;
        font-weight: 700;
        font-size: 16px;
        opacity: 0.7;
    }

    .progress__bar {
        height: 6px;
        width: 100%;
        cursor: pointer;
        background-color: #d0d8e6;
        display: inline-block;
        border-radius: 10px;
    }

    .progress__current {
        height: inherit;
        width: 0%;
        background-color: #532ab9;
        border-radius: 10px;
    }

    .album-info {
        margin-top: 38px;
        color: #71829e;
        flex: 1;
        padding-right: 60px;
        user-select: none;
    }
    @media screen and (max-width: 576px), (max-height: 500px) {
        .album-info {
            padding-right: 30px;
        }
    }
    .album-info__name {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 12px;
        line-height: 1.3em;
    }
    @media screen and (max-width: 576px), (max-height: 500px) {
        .album-info__name {
            font-size: 18px;
            margin-bottom: 9px;
        }
    }
    .album-info__track {
        font-weight: 400;
        font-size: 20px;
        opacity: 0.7;
        line-height: 1.3em;
        min-height: 52px;
    }
    @media screen and (max-width: 576px), (max-height: 500px) {
        .album-info__track {
            font-size: 18px;
            min-height: 50px;
        }
    }

    .github-btn {
        position: absolute;
        right: 40px;
        bottom: 50px;
        text-decoration: none;
        padding: 15px 25px;
        border-radius: 4px;
        box-shadow: 0px 4px 30px -6px rgba(36, 52, 70, 0.65);
        background: #24292e;
        color: #fff;
        font-weight: bold;
        letter-spacing: 1px;
        font-size: 16px;
        transition: all 0.3s ease-in-out;
    }
    @media screen and (min-width: 500px) {
        .github-btn:hover {
            transform: scale(1.1);
            box-shadow: 0px 17px 20px -6px rgba(36, 52, 70, 0.36);
        }
    }
    @media screen and (max-width: 700px) {
        .github-btn {
            position: relative;
            bottom: auto;
            right: auto;
            margin-top: 20px;
        }
        .github-btn:active {
            transform: scale(1.1);
            box-shadow: 0px 17px 20px -6px rgba(36, 52, 70, 0.36);
        }
    }

    .scale-out-enter-active {
        transition: all 0.35s ease-in-out;
    }

    .scale-out-leave-active {
        transition: all 0.35s ease-in-out;
    }

    .scale-out-enter {
        transform: scale(0.55);
        pointer-events: none;
        opacity: 0;
    }

    .scale-out-leave-to {
        transform: scale(1.2);
        pointer-events: none;
        opacity: 0;
    }

    .scale-in-enter-active {
        transition: all 0.35s ease-in-out;
    }

    .scale-in-leave-active {
        transition: all 0.35s ease-in-out;
    }

    .scale-in-enter {
        transform: scale(1.2);
        pointer-events: none;
        opacity: 0;
    }

    .scale-in-leave-to {
        transform: scale(0.55);
        pointer-events: none;
        opacity: 0;
    }

    /*# sourceMappingURL=main.css.map */
    .fa {

        z-index: 2;
        cursor: pointer;

    }

    .icon-player-content {

        text-align: center;

    }
</style>

<script>
    export default {
        data() {
            return {
                audio: null,
                circleLeft: null,
                barWidth: null,
                duration: null,
                currentTime: null,
                isTimerPlaying: false,
                tracks: [
                    {
                        name: "José Ferreira",
                        artist: "Pastor",
                        cover: "https://scontent.fplu3-1.fna.fbcdn.net/v/t1.0-9/32378529_1797984020258145_3897478320547168256_n.jpg?_nc_cat=111&_nc_ohc=pH39175ADaYAX_3GdsX&_nc_ht=scontent.fplu3-1.fna&oh=49c7510b3e76c342b30e3637165259fd&oe=5EC7A69E",
                        source: "/audio/WhatsApp Audio 2020-01-29 at 00.12.08.mpeg",
                        url: "/audio/WhatsApp Audio 2020-01-29 at 00.12.08.mpeg",
                        favorited: true
                    }
                ],
                currentTrack: null,
                currentTrackIndex: 0,
                transitionName: null
            };
        },
        methods: {
            create () {

                let vm = this;
                this.currentTrack = this.tracks[0];
                this.audio = new Audio();
                this.audio.src = this.currentTrack.source;
                this.audio.ontimeupdate = function() {
                    vm.generateTime();
                };
                this.audio.onloadedmetadata = function() {
                    vm.generateTime();
                };
                this.audio.onended = function() {
                    vm.nextTrack();
                    this.isTimerPlaying = true;
                };

                // this is optional (for preload covers)
                for (let index = 0; index < this.tracks.length; index++) {
                    const element = this.tracks[index];
                    let link = document.createElement('link');
                    link.rel = "prefetch";
                    link.href = element.cover;
                    link.as = "image"
                    document.head.appendChild(link)
                }

            },
            play() {
                if (this.audio.paused) {
                    this.audio.play();
                    this.isTimerPlaying = true;
                } else {
                    this.audio.pause();
                    this.isTimerPlaying = false;
                }
            },
            generateTime() {
                let width = (100 / this.audio.duration) * this.audio.currentTime;
                this.barWidth = width + "%";
                this.circleLeft = width + "%";
                let durmin = Math.floor(this.audio.duration / 60);
                let dursec = Math.floor(this.audio.duration - durmin * 60);
                let curmin = Math.floor(this.audio.currentTime / 60);
                let cursec = Math.floor(this.audio.currentTime - curmin * 60);
                if (durmin < 10) {
                    durmin = "0" + durmin;
                }
                if (dursec < 10) {
                    dursec = "0" + dursec;
                }
                if (curmin < 10) {
                    curmin = "0" + curmin;
                }
                if (cursec < 10) {
                    cursec = "0" + cursec;
                }
                this.duration = durmin + ":" + dursec;
                this.currentTime = curmin + ":" + cursec;
            },
            updateBar(x) {
                let progress = this.$refs.progress;
                let maxduration = this.audio.duration;
                let position = x - progress.offsetLeft;
                let percentage = (100 * position) / progress.offsetWidth;
                if (percentage > 100) {
                    percentage = 100;
                }
                if (percentage < 0) {
                    percentage = 0;
                }
                this.barWidth = percentage + "%";
                this.circleLeft = percentage + "%";
                this.audio.currentTime = (maxduration * percentage) / 100;
                this.audio.play();
            },
            clickProgress(e) {
                this.isTimerPlaying = true;
                this.audio.pause();
                this.updateBar(e.pageX);
            },
            prevTrack() {

                if (this.tracks.length < 2) {

                    return;

                }

                this.transitionName = "scale-in";
                this.isShowCover = false;
                if (this.currentTrackIndex > 0) {
                    this.currentTrackIndex--;
                } else {
                    this.currentTrackIndex = this.tracks.length - 1;
                }
                this.currentTrack = this.tracks[this.currentTrackIndex];
                this.resetPlayer();
            },
            nextTrack() {

                if (this.tracks.length < 2) {

                    return;

                }


                this.transitionName = "scale-out";
                this.isShowCover = false;
                if (this.currentTrackIndex < this.tracks.length - 1) {
                    this.currentTrackIndex++;
                } else if (this.tracks.length > 1) {
                    this.currentTrackIndex = 0;
                }
                this.currentTrack = this.tracks[this.currentTrackIndex];
                this.resetPlayer();
            },
            resetPlayer() {
                this.barWidth = 0;
                this.circleLeft = 0;
                this.audio.currentTime = 0;
                this.audio.src = this.currentTrack.source;
                setTimeout(() => {
                    if(this.isTimerPlaying) {
                        this.audio.play();
                    } else {
                        this.audio.pause();
                    }
                }, 300);
            },
            changeTime (change) {

                if (!this.audio.currentTime) {
                    this.audio.currentTime=0;
                }

                this.audio.currentTime = (this.audio.currentTime + change).toString();

            },
            favorite() {
                this.tracks[this.currentTrackIndex].favorited = !this.tracks[
                    this.currentTrackIndex
                    ].favorited;
            }
        },
        created() {

            this.create();

        }

    }
</script>
