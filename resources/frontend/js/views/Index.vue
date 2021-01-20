<template >
  <b-container fluid class="bv-example-row" style="padding: 0px">
    <section>
      <div class="back-img">
        <div class="box1">
          <div>
            <h1>交友首頁</h1>
            <b-button class="reg-btn" type="submit">
              <h3>註冊</h3>
            </b-button>
          </div>
        </div>
      </div>
    </section>
    <section>
      <div class="box2" ref="infoBox" @mousewheel="scrollEvent($event)">
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
    <section>
      <div class="footer">
        <b-row>
          <b-col>
            <h2><i>公司</i></h2>
            <ul class="list-unstyled">
              <li><a href="">聯絡</a></li>
              <li><a href="">安全性</a></li>
              <li><a href="">訂閱方案</a></li>
            </ul>
          </b-col>
          <b-col>
            <h2><i>社群</i></h2>
            <ul class="list-unstyled">
              <li><a href="">部落格</a></li>
              <li><a href="">媒體報到</a></li>
              <li><a href="">支援</a></li>
              <li><a href="">促銷</a></li>
            </ul>
          </b-col>
          <b-col>
            <h2><i>合作夥伴</i></h2>
            <ul class="list-unstyled">
              <li><a href="">Spotify</a></li>
              <li><a href="">Netflix</a></li>
            </ul>
          </b-col>
          <b-col>
            <h2><i>法務</i></h2>
            <ul class="list-unstyled">
              <li><a href="">隱私</a></li>
              <li><a href="">條款</a></li>
              <li><a href="">Cookie</a></li>
              <li><a href="">社群規範</a></li>
              <li><a href="">安全政策</a></li>
              <li><a href="">智慧財產權</a></li>
            </ul>
          </b-col>
        </b-row>
      </div>
    </section>
    <footer>
      <div class="footer" style="height: 20vh"></div>
    </footer>
  </b-container>
</template>

<script>
export default {
  data() {
    return {
      domObj: document.getElementById("box2"),
      boxWidth: 0,
      boxScroll: 0,
      boxTatol: 0,
      timeStatus: null,
    };
  },
  mounted() {
    this.timer();
    console.log(this.$route.path);
  },
  methods: {
    scrollEvent: function (event) {
      event.preventDefault();
      for (let i = 0; i < event.path.length; i++) {
        if (event.path[i].className == "box2") {
          this.boxWidth = event.path[i].offsetWidth;
          this.boxScroll = event.path[i].scrollLeft;
          if (event.deltaY > 0) {
            event.path[i].scrollLeft += this.boxWidth;
          } else {
            event.path[i].scrollLeft -= this.boxWidth;
          }
        }
      }
    },
    timer: function () {
      this.timeStatus = setInterval(() => {
        this.scroll();
      }, 5000);
    },
    scroll: function () {
      this.boxTatol =
        this.$refs.infoBox.scrollLeft + this.$refs.infoBox.offsetWidth;
      if (this.boxTatol == this.$refs.infoBox.scrollWidth) {
        this.$refs.infoBox.scrollLeft = 0;
      }
      var a = (this.$refs.infoBox.scrollLeft += this.$refs.infoBox.offsetWidth);
      console.log(a);
    },
  },
    beforeDestroy() {
      clearInterval(this.timeStatus);   
    },
    destroyed() {
      clearInterval(this.timeStatus);
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
.reg-btn {
  width: 100%;
  margin-top: 25px;
  border-radius: 25px !important;
  background: darksalmon linear-gradient(to right, rgba(0, 255, 0, 0), Crimson) !important;
  transition: background-color 0.5s;
}
.reg-btn h3 {
  font-weight: 900;
}
.box2 {
  width: auto;
  height: 17rem;
  overflow: hidden;
  overflow-x: scroll;
  overflow-y: scroll;
  margin: 40px 45px 5px 45px;
  display: flex;
  scroll-behavior: smooth;
}
.text-center {
  min-width: 32% !important;
  margin-left: 1%;
  box-shadow: 3px 3px 4px rgba(0, 0, 0, 0.2);
  height: 95%;
}
.back-img {
  background-image: url("https://images.pexels.com/photos/3877815/pexels-photo-3877815.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940");
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
.footer {
  width: auto;
  /* height: 20vh; */
  margin: 40px 65px 5px 65px;
  border-top: 1px solid rgba(0, 0, 0, 0.25);
  padding: 20px;
}
.list-unstyled li {
  margin-top: 10px;
  color: black !important;
}
</style>