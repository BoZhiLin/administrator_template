<template >
  <b-container fluid style="padding: 0px" >
    <section >
      <div class="back-img" >
        <div class="box1 ">
          <h1>交友首頁</h1>
        </div>
      </div>
    </section>
    <section>
      <div  class="box2" @mousewheel="scrollEvent($event)" >
          <b-card header="Default" class="text-center">
            <b-card-text
              >Lorem ipsum dolor sit amet, consectetur adipiscing
              elit.</b-card-text
            >
          </b-card>
          <b-card header="Default" class="text-center">
            <b-card-text
              >Lorem ipsum dolor sit amet, consectetur adipiscing
              elit.</b-card-text
            >
          </b-card>

          <b-card header="Default" class="text-center">
            <b-card-text
              >Lorem ipsum dolor sit amet, consectetur adipiscing
              elit.</b-card-text
            > </b-card
          ><b-card header="Default" class="text-center">
            <b-card-text
              >Lorem ipsum dolor sit amet, consectetur adipiscing
              elit.</b-card-text
            >
          </b-card>
          <b-card header="Default" class="text-center">
            <b-card-text
              >Lorem ipsum dolor sit amet, consectetur adipiscing
              elit.</b-card-text
            >
          </b-card>
          <b-card header="Default" class="text-center">
            <b-card-text
              >Lorem ipsum dolor sit amet, consectetur adipiscing
              elit.</b-card-text
            >
          </b-card>
          <b-card header="Default" class="text-center">
            <b-card-text
              >Lorem ipsum dolor sit amet, consectetur adipiscing
              elit.</b-card-text
            >
          </b-card>
        </div>
    </section>
    <footer>
      <div class="footer">

      </div>
    </footer>
  </b-container>
</template>

<script>
export default {
  data() {
    return {
        domObj: document.getElementById('box2'),
        // deltaX:0
    };
  },
  mounted() {
   
  },
  methods: {
    scrollEvent:function(event) {
        event.preventDefault(); 
        for (let i = 0; i < event.path.length; i++) {
          if(event.path[i].className == "box2"){
            if (event.deltaY > 0) {
              console.log(event.path[i].scrollLeft +=50);
            }
            else{
              console.log(event.path[i].scrollLeft -=50 );
            }
          }
          
        }
    
    },
    
  },
};
</script>

<style>
.box1 {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh !important;
}
.box1 h1 {
  font-weight: 900;
  color: aliceblue;
  font-size: 4.5rem;
}
.box2 {
  width: auto;
  height: 20vh;
  overflow: hidden;
  overflow-x: scroll;
  overflow-y: scroll;
  margin: 40px 45px 5px 45px;
  display: flex
  
}
.text-center {
  min-width: 32% !important;
  margin-left: 1%;
}
.back-img {
  background-image: url(https://images.pexels.com/photos/3877815/pexels-photo-3877815.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940);
  margin-bottom: 0px !important;
  background-color: rgba(0, 0, 0, 0.3);
  background-blend-mode: multiply;
  background-position: center;
  background-size: cover;
  background-attachment: fixed; /*下滑特效*/
  z-index: -1;
}
::-webkit-scrollbar {
  /*隱藏滾輪*/
  display: none;
}
.footer{
  width: auto;
  height: 20vh;
  margin: 40px 45px 5px 45px;
  border-top: 1px solid rgba(0, 0, 0, 0.25);
}
</style>