<template>
    <div class="container-fluid">
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
            <div class="col-12 col-xs-12 col-md-7 screen-height">
                <div class="row">
                    <div class="col-12 col-xs-12">

                    </div>
                </div>
            </div>
            <div class="col-12 col-md-5 screen-height player-place">
                <audio-player :audios="playlist"></audio-player>
            </div>
        </div>
        <div class="para-Ele">
            Tudo para a honra e glória do Senhor!
        </div>
    </div>
</template>

<style scoped>

    .player-place {

        background-color: #eae8e8;

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

    .screen-height {

        height: initial;
        min-height: calc(100vh - 60px);

    }

</style>

<script>
    export default {
        data: function () {
            return {
                playlist :
                [
                    {
                        name: "Split",
                        artist: "Seconds Away",
                        cover: "https://i.scdn.co/image/ab67616d0000b2733ff758754da9f449e24c5176",
                        source: "/audio/Seconds Away - Split [HD].mp3",
                        url: "/audio/download/Seconds Away - Split [HD].mp3",
                        favorited: true
                    },
                    {
                        name: "Nice Try",
                        artist: "Nevertel",
                        cover: "https://i1.sndcdn.com/avatars-000718395724-ry50ph-t500x500.jpg",
                        source: "/audio/Nevertel - Nice Try [HD].mp3",
                        url: "/audio/download/Nevertel - Nice Try [HD].mp3",
                        favorited: true
                    }
                ]

            }
        },
        methods: {
            change () {
                this.playlist =
                [
                    {
                        name: "José Ferreira",
                        artist: "Pastor",
                        cover: "https://www.dioceseunivitoria.org.br/wp-content/uploads/2018/09/biblia.jpg",
                        source: "/audio/WhatsApp Audio 2020-01-29 at 00.12.08.mpeg",
                        url: "/audio/download/WhatsApp Audio 2020-01-29 at 00.12.08.mpeg",
                        favorited: true
                    }
                ]
            }
        }

    }
</script>
