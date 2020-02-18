<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-xs-12 col-md-7 screen-height">
                <div class="row">
                    <div class="col-12 col-xs-12 playlist-header">
                        <div class="row logo-content">
                            <div>
                                <img data-v-9b01884e="" src="/imgs/escrituras.png" class="logo-img">
                            </div>
                            <div class="logo-text">
                                Somente as Escrituras
                            </div>

                        </div>
                        <div class="pull-right search-icon" @click="change">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="col-12 col-xs-12">

                    </div>
                </div>
            </div>
            <div class="col-12 col-md-5 screen-height player-place">
                <audio-player :audios="test"></audio-player>
            </div>
        </div>
        <div class="para-Ele">
            Tudo para a honra e glória do Senhor!
        </div>
    </div>
</template>

<style scoped>

    .player-place {

        background-color: #f5f5f5;

    }

    .playlist-header {

        background-color: #532ab9;
        height: 60px;
        color: #FFF;
        z-index: 2;

    }

    .para-Ele {

        position: absolute;
        bottom: 5px;
        right: 5%;

    }
    .logo-img {

        height: 90px;
        padding-top: 8px;

    }

    .logo-text {

        font-size: 15px;
        padding-top: 6px;
        margin-left: 15px;
        width: 90px;
        font-family: Georgia, serif;

    }

    .search-icon:hover, .logo-content:hover {

        color: #EEE;

    }

    .search-icon {

        position: absolute;
        right: 3%;
        top: 50%;
        transform: translateY(-50%);
        font-size: 18px;
        cursor: pointer;

    }

</style>

<script>
    export default {
        data: function () {
            return {
                test :
                [
                    {
                        name: "José Ferreira",
                        artist: "Pastor",
                        cover: "https://scontent.fplu3-1.fna.fbcdn.net/v/t1.0-9/32378529_1797984020258145_3897478320547168256_n.jpg?_nc_cat=111&_nc_ohc=pH39175ADaYAX_3GdsX&_nc_ht=scontent.fplu3-1.fna&oh=49c7510b3e76c342b30e3637165259fd&oe=5EC7A69E",
                        source: "/file/WhatsApp Audio 2020-01-29 at 00.12.08.mpeg",
                        url: "/file/download/WhatsApp Audio 2020-01-29 at 00.12.08.mpeg",
                        favorited: true
                    }
                ]
            }
        },
        methods: {
            change () {
                this.test = [
                    {
                        name: "Split",
                        artist: "Seconds Away",
                        cover: "https://i.scdn.co/image/ab67616d0000b2733ff758754da9f449e24c5176",
                        source: "/file/Seconds Away - Split [HD].mp3",
                        url: "/file/download/Seconds Away - Split [HD].mp3",
                        favorited: true
                    },
                    {
                        name: "Nice Try",
                        artist: "Nevertel",
                        cover: "https://i1.sndcdn.com/avatars-000718395724-ry50ph-t500x500.jpg",
                        source: "/file/Nevertel - Nice Try [HD].mp3",
                        url: "/file/download/Nevertel - Nice Try [HD].mp3",
                        favorited: true
                    }
                ]

            }
        }

    }
</script>
