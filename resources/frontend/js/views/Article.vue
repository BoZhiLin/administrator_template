<template>
  <div class="bg-img">
    <img :src="scr_img" alt="" />
  </div>
</template>

<script>
export default {
  data() {
    return {
      scr_img:
        "https://images.pexels.com/photos/994605/pexels-photo-994605.jpeg?cs=srgb&dl=pexels-fabian-wiktor-994605.jpg&fm=jpg",
      new_date:"",
    }
  },
  created:function(){
    console.log(123);
        var a = new Date(localStorage.getItem("expired_at") * 1000);
        var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        var year = a.getFullYear();
        var month = months[a.getMonth()];
        var date = a.getDate();
        var hour = a.getHours();
        var min = a.getMinutes();
        var sec = a.getSeconds();
        this.new_date = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec ;
        console.log(this.new_date);
      },
      watch: {
        app(app) {
          console.log("testarticle", this.app);
        },
      },
    }
</script>

<style>
.bg-img {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100%;
  max-height: 500px;
  min-height: 380px;
  overflow: hidden;
  top: 0%;
  margin-bottom: 15px;
}
</style>
