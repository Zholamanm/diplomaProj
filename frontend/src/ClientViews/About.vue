<template>
  <div class="about-page">
    <h1 class="page-title">Our Story</h1>
    <p class="page-subtitle">Discover the journey behind our book-sharing community</p>

    <div class="book-carousel">
      <div class="container">
        <!-- Page 1: Cover -->
        <div class="right">
          <figure class="back" id="back-cover" style="background: linear-gradient(135deg, #ffcb63, #ef9f00);"></figure>
          <figure class="front" id="cover">
            <div class="cover-content">
              <h1>BookShare</h1>
              <p class="tagline">Connecting readers since 2025</p>
              <div class="cover-logo">📚</div>
            </div>
          </figure>
        </div>

        <!-- Page 2: Mission -->
        <div class="right">
          <figure class="back" style="background-image: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80');"></figure>
          <figure class="front">
            <div class="page-content">
              <h2>Our Mission</h2>
              <p>We aim to simplify and modernize library services by replacing outdated systems with a smart, user-friendly platform for book reservations and sharing.</p>
              <div class="icon">💫</div>
            </div>
          </figure>
        </div>

        <!-- Page 4: Features -->
        <div class="right">
          <figure class="back" style="background-image: url('https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80');"></figure>
          <figure class="front">
            <div class="page-content">
              <h2>Unique Features</h2>
              <ul>
                <li>Smart Book Recommendations — tailored to users' interests and reading history.</li>
                <li>Booking System — find and book the books near to you.</li>
                <li>Favorites & Blacklist — manage your reading preferences and interactions.</li>
                <li>Built-in Chat — communicate directly with other users within the platform.</li>
              </ul>
              <div class="icon">✨</div>
            </div>
          </figure>
        </div>

        <!-- Page 5: Team -->
        <div class="right">
          <figure class="back" style="background-image: url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80');"></figure>
          <figure class="front">
            <div class="page-content">
              <h2>Our Team</h2>
              <p>We are a group of tech-savvy students from Astana IT University who love books and innovation. Together, we created this project to connect readers and make sharing books easier and more fun.</p>
              <div class="icon">❤️</div>
            </div>
          </figure>
        </div>

        <!-- Page 6: Join Us -->
        <div class="right">
          <figure class="back" style="background-image: url('https://images.unsplash.com/photo-1506880018603-83d5b814b5a6?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80');"></figure>
          <figure class="front">
            <div class="page-content">
              <h2>Join Us</h2>
              <p>Ready to start your book-sharing journey?</p>
              <button class="join-btn" @click="$router.push({name: 'login', params: { locale: $route.params.locale}})">Become a Member</button>
              <div class="icon">📖</div>
            </div>
          </figure>
        </div>
      </div>

      <div class="controls">
        <button class="nav-button left-button" @click="turnLeft">‹</button>
        <button class="nav-button right-button" @click="turnRight">›</button>
      </div>
    </div>
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
.about-page {
  min-height: 100vh;
  padding: 2rem;
  background: linear-gradient(135deg, #f9f9f9 0%, #e8f4f8 100%);
  text-align: center;
  font-family: 'Lato', sans-serif;
}

.page-title {
  font-size: 2.5rem;
  color: #2c3e50;
  margin-bottom: 0.5rem;
  font-family: 'Roboto Slab', serif;
}

.page-subtitle {
  color: #7f8c8d;
  margin-bottom: 3rem;
  font-size: 1.2rem;
}

.book-carousel {
  max-width: 900px;
  margin: 0 auto;
  position: relative;
}

.container {
  height: 500px;
  width: 700px;
  position: relative;
  margin: 0 auto;
  perspective: 1200px;
}

.right {
  position: absolute;
  height: 100%;
  width: 50%;
  transition: 0.7s ease-in-out;
  transform-style: preserve-3d;
  right: 0;
  transform-origin: left;
}

.right > figure.front,
.right > figure.back {
  margin: 0;
  height: 100%;
  width: 100%;
  position: absolute;
  left: 0;
  top: 0;
  background-size: cover;
  background-position: center;
  backface-visibility: hidden;
  overflow: hidden;
  border-radius: 5px;
}

.right > figure.front {
  background-color: #ffffff;
  box-shadow: 0 10px 25px rgba(0,0,0,0.1);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem;
}

.right > figure.back {
  transform: rotateY(180deg);
}

.flip {
  transform: rotateY(-180deg);
}

.controls {
  margin-top: 2rem;
  display: flex;
  justify-content: center;
  gap: 1rem;
}

.nav-button {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  border: none;
  background: #219e9a;
  color: white;
  font-size: 1.5rem;
  cursor: pointer;
  transition: all 0.3s;
  display: flex;
  align-items: center;
  justify-content: center;
}

.nav-button:hover {
  background: #1a7f7b;
  transform: scale(1.1);
}

/* Page Content Styles */
.page-content {
  max-width: 90%;
  text-align: center;
}

.page-content h2 {
  color: #2c3e50;
  margin-bottom: 1.5rem;
  font-family: 'Roboto Slab', serif;
}

.page-content p {
  color: #34495e;
  line-height: 1.6;
  margin-bottom: 1.5rem;
}

.page-content ul {
  text-align: left;
  padding-left: 1.5rem;
}

.page-content li {
  margin-bottom: 0.5rem;
  color: #34495e;
}

.icon {
  font-size: 2.5rem;
  margin-top: 1rem;
  opacity: 0.8;
}

/* Cover Styles */
#cover {
  background: linear-gradient(135deg, #ffcb63 0%, #ef9f00 100%);
}

.cover-content {
  text-align: center;
  color: white;
}

.cover-content h1 {
  font-size: 3rem;
  margin-bottom: 0.5rem;
  text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
}

.tagline {
  font-size: 1.2rem;
  margin-bottom: 2rem;
  opacity: 0.9;
}

.cover-logo {
  font-size: 4rem;
  margin-top: 2rem;
}

/* Join Button */
.join-btn {
  padding: 0.8rem 2rem;
  background: #219e9a;
  color: white;
  border: none;
  border-radius: 50px;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s;
  margin-top: 1rem;
}

.join-btn:hover {
  background: #1a7f7b;
  transform: translateY(-3px);
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

/* Responsive Design */
@media (max-width: 768px) {
  .container {
    width: 90%;
    height: 400px;
  }

  .page-title {
    font-size: 2rem;
  }

  .page-content {
    padding: 1rem;
  }
}
</style>