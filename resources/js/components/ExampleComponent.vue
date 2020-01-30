<template>
    <div class="container">
        <div class="row justify-content-center" v-on:click="sum()">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component. {{ quantidade }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                quantidade : 0
            }
        },
        methods: {
            sum: function () {
                this.quantidade += 1;
            }
        }

    }
</script>
