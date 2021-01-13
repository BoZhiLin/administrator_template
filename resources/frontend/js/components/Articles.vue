<template>
    <div>
        <h2>articles</h2>
        <input type="text" v-model="app">
    </div>
</template>


<script>
export default {
    data() {
        return {
            app:"",
        }
    },
    watch:{
        app(app)
        {console.log("testarticle" , this.app);}
    }

}
</script>

<style>

</style>
