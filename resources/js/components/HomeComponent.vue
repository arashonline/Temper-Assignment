<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Welcome To Temper Assginment</div>

                    <div class="card-body">
                        <h1 v-if="this.temper">
<!--                            fixme use dynamic route in vue-->
                        <a href="analytic" >Analytic</a>
                        </h1>
                        <h1 v-else>There is nothing to show right now.</h1>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['temper','analytic'],
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
