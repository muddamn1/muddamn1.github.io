$(document).ready(function() {
  'use strict';

  // --- Preloader ---
  $(window).on('load', function() {
    if ($('#preloader').length) {
      $('#preloader').delay(100).fadeOut('slow', function() {
        $(this).remove();
      });
    }
  });

  // --- Back to top button ---
  // --- Back to top button ---
  const backtotop = $('.back-to-top');
  $(window).scroll(function() {
    if ($(this).scrollTop() > 200) { // Show button after scrolling 200px
      backtotop.addClass('active');
    } else {
      backtotop.removeClass('active');
    }
  });
  backtotop.on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({
      scrollTop: 0
    }, 800, 'easeInOutExpo'); // Slower, smoother scroll with easeInOutExpo
    return false;
  });

  // --- Typed.js for hero section ---
  if ($('.typed').length) {
    let typed_strings = $(".typed").data('typed-items');
    typed_strings = typed_strings.split(',')
    new Typed('.typed', {
      strings: typed_strings,
      loop: true,
      typeSpeed: 100,
      backSpeed: 50,
      backDelay: 2000
    });
  }

  // --- Mobile Navigation Toggle ---
  $(document).on('click', '.mobile-nav-toggle', function(e) {
    $('body').toggleClass('mobile-nav-active');
    $('.mobile-nav-toggle i').toggleClass('bi-list bi-x');
    $('#navbar ul').slideToggle(200);
  });

  // --- Smooth scroll for navigation menu and active class handling ---
  $(document).on('click', '.nav-link.scrollto, .navbar a[href^="#"]', function(e) {
    const hash = this.hash;
    const target = $(hash);
    if (target.length) {
      e.preventDefault();
      $('html, body').animate({
        scrollTop: target.offset().top - 70 // Adjusted offset for fixed header
      }, 600, 'swing'); // Use 'swing' easing as jQuery UI is not included
      
      // Update active class
      $('.navbar .nav-link').removeClass('active');
      $(this).addClass('active');

      // Close mobile nav if open
      if ($('body').hasClass('mobile-nav-active')) {
        $('body').removeClass('mobile-nav-active');
        $('.mobile-nav-toggle i').toggleClass('bi-list bi-x');
        $('#navbar ul').slideUp(200);
      }
    }
  });

  // --- Activate scrollspy to add active class to navbar items on scroll ---
  $(window).on('load scroll', function() {
    const scrollPos = $(document).scrollTop() + 80; // Adjusted offset
    $('.nav-link.scrollto').each(function() {
      const currLink = $(this);
      const refElement = $(currLink.attr('href'));
      if (refElement.length && refElement.offset().top <= scrollPos && refElement.offset().top + refElement.height() > scrollPos) {
        $('.navbar .nav-link').removeClass('active');
        currLink.addClass('active');
      } else {
        currLink.removeClass('active');
      }
    });
  });

  // --- Cookie-based Welcome Greeting ---
  function friendlyGreeting() {
    const welcomeBanner = $('#welcome-banner');
    if (!welcomeBanner.length) return;

    const lastVisitCookie = document.cookie.split('; ').find(row => row.startsWith('lastVisit='));
    let message = 'Welcome to my portfolio!';
    let isNewUser = true;

    if (lastVisitCookie) {
      const lastVisitDate = new Date(decodeURIComponent(lastVisitCookie.split('=')[1]));
      message = `Welcome back! Last visit: ${lastVisitDate.toLocaleString()}`;
      isNewUser = false;
    }

    welcomeBanner.text(message);
    welcomeBanner.addClass('show'); // Add class to trigger animation

    // Set cookie for 1 year expiry
    document.cookie = `lastVisit=${encodeURIComponent(new Date().toISOString())};path=/;max-age=31536000`;

    // If it's a new user, show the banner for a longer duration
    if (isNewUser) {
      setTimeout(() => {
        welcomeBanner.removeClass('show');
      }, 10000); // Show for 10 seconds for new users
    } else {
      setTimeout(() => {
        welcomeBanner.removeClass('show');
      }, 6000); // Show for 6 seconds for returning users
    }
  }
  friendlyGreeting();

  // --- Live Clocks ---
  function initializeClocks() {
    const digitalClock = $('#digital-clock');
    const analogClockCanvas = document.getElementById('analog-clock');

    if (digitalClock.length) {
      const updateDigitalClock = () => digitalClock.text(new Date().toLocaleTimeString());
      updateDigitalClock();
      setInterval(updateDigitalClock, 1000);
    }

    if (analogClockCanvas) {
      const ctx = analogClockCanvas.getContext('2d');
      const radius = analogClockCanvas.height / 2;
      ctx.translate(radius, radius);

      const drawHand = (pos, length, width, color) => {
          ctx.beginPath();
          ctx.lineWidth = width;
          ctx.lineCap = "round";
          ctx.strokeStyle = color;
          ctx.moveTo(0,0);
          ctx.rotate(pos);
          ctx.lineTo(0, -length);
          ctx.stroke();
          ctx.rotate(-pos);
      }

      const drawClock = () => {
          ctx.clearRect(-radius, -radius, analogClockCanvas.width, analogClockCanvas.height);
          // Draw face
          ctx.beginPath();
          ctx.arc(0, 0, radius * 0.9, 0, 2 * Math.PI);
          ctx.fillStyle = '#FFFFFF'; /* White clock face */
          ctx.fill();
          ctx.strokeStyle = '#BBBBBB'; /* Light grey border */
          ctx.lineWidth = radius * 0.03;
          ctx.stroke();

          // Center dot
          ctx.beginPath();
          ctx.arc(0, 0, radius * 0.05, 0, 2 * Math.PI);
          ctx.fillStyle = '#333';
          ctx.fill();

          // Draw hands
          const now = new Date();
          const hour = now.getHours();
          const minute = now.getMinutes();
          const second = now.getSeconds();
          
          // Hour
          let hourAngle = (hour*Math.PI/6) + (minute*Math.PI/(6*60)) + (second*Math.PI/(360*60));
          drawHand(hourAngle, radius * 0.5, radius * 0.07, '#333333'); /* Dark grey hour hand */
          // Minute
          let minuteAngle = (minute * Math.PI / 30) + (second * Math.PI / (30 * 60));
          drawHand(minuteAngle, radius * 0.75, radius * 0.05, '#555555'); /* Slightly lighter minute hand */
          // Second
          let secondAngle = (second * Math.PI / 30);
          drawHand(secondAngle, radius * 0.8, radius * 0.02, '#E74C3C'); /* Red second hand */
      }
      drawClock();
      setInterval(drawClock, 1000);
    }
  }
  initializeClocks();

  // --- Joke of the Minute (from JokeAPI) ---
  async function fetchJoke() {
    const jokeContainer = $('#joke-text');
    if (!jokeContainer.length) return;

    try {
      const response = await fetch('https://v2.jokeapi.dev/joke/Programming,Pun?type=single');
      if (!response.ok) throw new Error('Network response was not ok');
      const data = await response.json();
      jokeContainer.text(data.joke || 'No joke found, but that\'s the real joke!');
    } catch (error) {
      console.error("Failed to fetch joke:", error);
      jokeContainer.text('Could not load joke. Please try again later.');
    }
  }
  fetchJoke();
  setInterval(fetchJoke, 60000);

  // --- Random XKCD Comic ---
  async function fetchComic() {
    const comicContainer = $('#comic-container');
    if (!comicContainer.length) return;

    // XKCD does NOT send CORS headers, so direct fetch will fail on localhost or file://
    // Solution: Use a public CORS proxy (e.g. allorigins), or fallback to a static XKCD comic if fetch fails.

    const randomComicId = Math.floor(Math.random() * 2500) + 1;
    const apiUrl = `https://xkcd.com/${randomComicId}/info.0.json`;
    const proxyUrl = `https://api.allorigins.win/get?url=${encodeURIComponent(apiUrl)}`;

    try {
      const response = await fetch(proxyUrl);
      if (!response.ok) throw new Error('Failed to load comic data');
      const data = await response.json();
      const comicData = JSON.parse(data.contents);
      comicContainer.html(`
        <strong class="d-block mb-2">${comicData.title}</strong>
        <img src="${comicData.img}" alt="${comicData.alt}" title="${comicData.alt}" class="img-fluid rounded">
      `);
    } catch (error) {
      console.error("Failed to fetch XKCD comic:", error);
      comicContainer.html('<p>Could not load a random comic. Enjoy a classic instead!</p><img src="https://imgs.xkcd.com/comics/compiling.png" alt="Compiling" class="img-fluid rounded">');
    }
  }
  fetchComic();

});