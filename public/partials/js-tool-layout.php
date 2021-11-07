<?php 
  get_header();
?>

<!-- 
  Vue.js style
<style>
<HTML>
<script> 
-->

<!-- CSS -->
<style>

* {
	box-sizing: border-box;
}

#blog {
	background-color: #296ca8;
	color: #fff;
	font-family: 'Roboto', sans-serif;
	display: flex;
	flex-direction: column;
	align-items: center;
	/* justify-content: center; */
	min-height: 100vh;
	margin: 0;
	padding-bottom: 100px;
}

h1 {
	margin-bottom: 0;
	text-align: center;
}

.filter-container {
	margin-top: 20px;
	width: 80vw;
	max-width: 800px;
}

.filter {
	width: 100%;
	padding: 12px;
	font-size: 20px;
  color: black;
}

.post {
	position: relative;
	background-color: #4992d3;
	box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
	border-radius: 3px;
	padding: 20px;
	margin: 40px 0;
	display: flex;
	width: 80vw;
	max-width: 800px;
}

.post .post-title {
	margin: 0;
  color: orange;
  font-weight: bold;

}

.post .post-body {
	margin: 15px 0 0;
	line-height: 1.3;
  text-align:left;
}

.post .post-info {
	margin-left: 40px;
}

.post .number {
	position: absolute;
	top: -30px;
	left: -30px;
	font-size: 15px;
	width: 60px;
	height: 60px;
	border-radius: 50%;
	background: #fff;
	color: #296ca8;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 7px 10px;
  font-weight:bold;
}

.loader {
	opacity: 0;
	display: flex;
	/* position: fixed; */
	/* bottom: 50px; */
	transition: opacity 0.3s ease-in;
}

.loader.show {
	opacity: 1;
}

.circle {
	background-color: #fff;
	width: 10px;
	height: 10px;
	border-radius: 50%;
	margin: 5px;
	animation: bounce 0.5s ease-in infinite;
}

.circle:nth-of-type(2) {
	animation-delay: 0.1s;
}

.circle:nth-of-type(3) {
	animation-delay: 0.2s;
}

@keyframes bounce {
	0%,
	100% {
		transform: translateY(0);
	}

	50% {
		transform: translateY(-10px);
	}
}

</style>
<!-- HTML -->
 <div class="border-2 border-yellow-500 p-2 text-2xl text-center bg-gray-300">
    <h1>This is the filter hook for page_template for JS</h1>
  
    <div id="root-js" class="text-blue-500"></div>
    </div>
    <div id="blog">
     <h1>My Blog</h1>

    <div class="filter-container">
      <input
        type="text"
        id="filter"
        class="filter"
        placeholder="Filter posts..."
      />
    </div>

    <div id="posts-container"></div>

    <div class="loader">
      <div class="circle"></div>
      <div class="circle"></div>
      <div class="circle"></div>
    </div>
  </div>
  </div>

  <!-- JS -->
  <script>
    console.log('This is public/partials')
    const app = document.getElementById('root-js');
    app.innerHTML = '<div style="text-align:center;margin-top:20px; padding:10px 20px;border:2px solid orange"><h2>JS injected HTML in plugin/public/js-tool-layout.php</h2></div>';


    const postsContainer = document.getElementById('posts-container');
    const loading = document.querySelector('.loader');
    const filter = document.getElementById('filter');

    let limit = 3;
    let page = 1;
    let loadmore = 'yes'

    // Fetch posts from API
    // `https://jsonplaceholder.typicode.com/posts?_limit=${limit}&_page=${page}`
    async function getPosts() {

      const url = `http://localhost/wp-boilerplate/wp-json/wp/v2/posts?per_page=${limit}&page=${page}`;
      const res = await fetch(url);
      console.log(res)
      if (res.ok) {
        const data = await res.json();   
        return data;
      } else {
        loadmore = 'no';
        return false;
      }
     
    }

    // Show posts in DOM
    async function showPosts() {
      console.log('loadmore', loadmore)
      const posts = await getPosts();
      console.log(posts);
      if (posts && loadmore == 'yes') {
        
        posts.map((post,i) => {
        const postEl = document.createElement('div');
        postEl.classList.add('post');

        postEl.innerHTML = `
          <div class="number">${posts[i].id}</div>
          <div class="post-info">
            <h2 class="post-title">${posts[i].title.rendered}</h2>
            <div class="post-body">${posts[i].excerpt.rendered} <a href="#">READ MORE &raquo;</a></div>
        `;
        postsContainer.appendChild(postEl);
        
      });

    } 
    if (loadmore == 'no') {
        const postEl = document.createElement('div');
        postEl.classList.add('post');

        postEl.innerHTML = `
          
          <div class="post-info">
            <h2 class="post-title">No more posts</h2>
          </div>
         
        `;
        postsContainer.appendChild(postEl);
        loadmore = 'stop';
    }
     
       
    }

    // Show loader & fetch more posts
    function showLoading() {
      if (loadmore != 'stop') {
        loading.classList.add('show');
        console.log('page', page)
        page++;
      
        showPosts();
        loading.classList.remove('show');
      }
     
       
    }

    // Filter posts by input
    function filterPosts(e) {
      const term = e.target.value.toUpperCase();
      const posts = document.querySelectorAll('.post');

      posts.forEach(post => {
        const title = post.querySelector('.post-title').innerText.toUpperCase();
        const body = post.querySelector('.post-body').innerText.toUpperCase();

        if (title.indexOf(term) > -1 || body.indexOf(term) > -1) {
          post.style.display = 'flex';
        } else {
          post.style.display = 'none';
        }
      });
    }

    // Show initial posts
    showPosts();

    window.addEventListener('scroll', () => {
      const { scrollTop, scrollHeight, clientHeight } = document.documentElement;

      if (scrollTop + clientHeight >= scrollHeight - 5) {
        showLoading();
      }
    });

    filter.addEventListener('input', filterPosts);

  </script>
 <?php
  get_footer(); 
?>