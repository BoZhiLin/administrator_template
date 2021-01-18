<template >
  <b-container fluid style="padding: 0px">
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
    <footer>
      <div class="footer"></div>
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
    };
  },
  mounted() {
    this.timer();
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
      return setInterval(() => {
        this.scroll();
      }, 5000);
    },
    scroll: function () {
      this.boxTatol =
        this.$refs.infoBox.scrollLeft + this.$refs.infoBox.offsetWidth;
      if (this.boxTatol == this.$refs.infoBox.scrollWidth) {
        this.$refs.infoBox.scrollLeft = 0;
      }
      this.$refs.infoBox.scrollLeft += this.$refs.infoBox.offsetWidth;
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
.reg-btn {
  width: 100%;
  margin-top: 25px;
  border-radius: 25px !important;
  background: darksalmon linear-gradient(to right, rgba(0, 255, 0, 0), Crimson) !important;
  transition: background-color 0.5s;
}
.reg-btn:hover {
  /* background-color: aliceblue !important;    */
  /* color: Crimson !important; */
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
  height: 20vh;
  margin: 40px 45px 5px 45px;
  border-top: 1px solid rgba(0, 0, 0, 0.25);
}
</style>