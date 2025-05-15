<template>
  <div class="book-section">
    <p>About us</p>
    <div class="container">
      <div class="right">
        <figure class="back" id="back-cover"></figure>
        <figure class="front" style="background-image: url('https://pixabay.com/get/gddfa70a7eb05131eb1d3bd2b6667e4397d3ca559b02e638b999fb15096eb5e6ca30d20cc903f216003acb583eb7ed64c_1280.jpg');"></figure>
      </div>
      <div class="right">
        <figure class="back" style="background-image: url('https://pixabay.com/get/gddfa70a7eb05131eb1d3bd2b6667e4397d3ca559b02e638b999fb15096eb5e6ca30d20cc903f216003acb583eb7ed64c_1280.jpg');"></figure>
        <figure class="front" style="background-image: url('https://pixabay.com/get/gb46f858d834c467d012d890214ee584025e70645dce58f87ef359bc4186c324cf80799862710eed4631eaf0464a6a3c6_1280.jpg');"></figure>
      </div>
      <div class="right">
        <figure class="back" style="background-image: url('https://pixabay.com/get/gb46f858d834c467d012d890214ee584025e70645dce58f87ef359bc4186c324cf80799862710eed4631eaf0464a6a3c6_1280.jpg');"></figure>
        <figure class="front" style="background-image: url('https://pixabay.com/get/g4df987b5bfa39878c10050859486a03f198027e2212376a2ccf6355644691efde0afe432da7e6644dd54fa12b3454a38_1280.jpg');"></figure>
      </div>
      <div class="right">
        <figure class="back" style="background-image: url('https://pixabay.com/get/g4df987b5bfa39878c10050859486a03f198027e2212376a2ccf6355644691efde0afe432da7e6644dd54fa12b3454a38_1280.jpg');"></figure>
        <figure class="front" style="background-image: url('https://pixabay.com/get/g21bf4539dcf9431362b0cdf0abd78d2578e9be101332dde74784aa43999043165f97edf8cbeffb236be99665f51bb560_1280.jpg');"></figure>
      </div>
      <div class="right">
        <figure class="back" style="background-image: url('https://pixabay.com/get/g21bf4539dcf9431362b0cdf0abd78d2578e9be101332dde74784aa43999043165f97edf8cbeffb236be99665f51bb560_1280.jpg');"></figure>
        <figure class="front" style="background-image: url('https://pixabay.com/get/ge136176f664b9cbc9bcb02ab48ec235083d9c4d7d7acee2f5a95098484cfb887e98c58aa4084f9f8bd6fc8c015be7ca0_1280.png');">Hello</figure>
      </div>
      <div class="right">
        <figure class="back" style="background-image: url('https://pixabay.com/get/ge136176f664b9cbc9bcb02ab48ec235083d9c4d7d7acee2f5a95098484cfb887e98c58aa4084f9f8bd6fc8c015be7ca0_1280.png');"></figure>
        <figure class="front" id="cover">
          <h1>Book Title</h1>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, modi.</p>
        </figure>
      </div>
    </div>
    <button class="left-button">Prev</button> <button class="right-button">Next</button>
    <br/>
  </div>
</template>
<script>
import $ from 'jquery';

export default {
  name: 'CatalogView',
  methods: {
    loadAbout() {
      var right = document.getElementsByClassName("right");
      var si = right.length;
      var z=1;
      turnRight();
      $('.left-button').on('click', function () {
        turnLeft()
      });
      $('.right-button').on('click', function () {
        turnRight()
      });
      function turnRight()
      {
        if(si>=1){
          si--;
        }
        else{
          si=right.length-1;
          // eslint-disable-next-line no-inner-declarations
          function sttmot(i){
            setTimeout(function(){right[i].style.zIndex="auto";},300);
          }
          for(var i=0;i<right.length;i++){
            right[i].className="right";
            sttmot(i);
            z=1;
          }
        }
        right[si].classList.add("flip");
        z++;
        right[si].style.zIndex=z;
      }
      function turnLeft()
      {
        if(si<right.length){
          si++;
        }
        else{
          si=1;
          for(var i=right.length-1;i>0;i--){
            right[i].classList.add("flip");
            right[i].style.zIndex=right.length+1-i;
          }
        }
        right[si-1].className="right";
        setTimeout(function(){right[si-1].style.zIndex="auto";},350);
      }
    },
  },
  mounted() {
    this.loadAbout()
  },
};
</script>
<style>
@import url(https://fonts.googleapis.com/css?family=Lato:400,300,700,900);
@import url(https://fonts.googleapis.com/css?family=Roboto+Slab:400,700);
@import url("https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css");
</style>
<style scoped>
.book-section{
  height: 100vh;
  width: 100%;
  padding: 40px 0;
  text-align: center;
}
.book-section > .container{
  height: 400px;
  width: 500px;
  position: relative;
  border-radius: 2%;
  margin-bottom: 30px;
  perspective: 1200px;
}
.container > .right{
  position: absolute;
  height: 100%;
  width: 50%;
  transition: 0.7s ease-in-out;
  transform-style: preserve-3d;
}
.book-section > .container > .right{
  right:0;
  transform-origin: left;
  border-radius: 10px 0 0 10px;
}
.right > figure.front, .right > figure.back{
  margin: 0;
  height: 100%;
  width: 100%;
  position: absolute;
  left:0;
  top:0;
  background-size: 200%;
  background-repeat: no-repeat;
  backface-visibility: hidden;
  background-color: white;
  overflow: hidden;
}
.right > figure.front{
  background-position: right;
  border-radius: 0 10px 10px 0;
  box-shadow: 2px 2px 15px -2px rgba(0,0,0,0.2);
}
.right > figure.back{
  background-position: left;
  border-radius: 10px 0 0 10px;
  box-shadow: -2px 2px 15px -2px rgba(0,0,0,0.2);
  transform: rotateY(180deg);
}
.flip{
  transform: rotateY(-180deg);
}
.flip::before{
  content: "";
  position: absolute;
  top:0;
  left:0;
  z-index: 10;
  width: 100%;
  height: 100%;
  border-radius: 0 10px 10px 0;
  background-color: rgba(0,0,0,0.1);
}
.book-section > button{
  border: 2px solid #ef9f00;
  background-color: transparent;
  color: #ef9f00;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  margin: 10px;
  transition: 0.3s ease-in-out;
}
.book-section > button:focus, .book-section > button:active{
  outline: none;
}
.book-section > p{
  color: rgba(0,0,0,0.7);
  font-family: calibri;
  font-size: 24px;
}
.book-section > p > a{
  text-decoration: none;
  color: #ef9f00;
}
.book-section > button:hover{
  background-color: #ef9f00;
  color: #fff;
}
.front#cover, .back#back-cover{
  background-color: #ffcb63;
  font-family: calibri;
  text-align: left;
  padding: 0 30px;
}
.front#cover h1{
  color: #fff;
}
.front#cover p{
  color: rgba(0,0,0,0.8);
  font-size: 14px;
}
</style>