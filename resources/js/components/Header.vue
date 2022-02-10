<template>

<header class="mb-5">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
           <router-link class="nav-link" :to="{name: 'home'}">Home</router-link>
        </li>
        <li class="nav-item">
           <router-link class="nav-link" :to="{name: 'about'}">About</router-link>
        </li>
        <li class="nav-item">
           <router-link class="nav-link" :to="{name: 'blog'}">Blog</router-link>
        </li>
        
      </ul>
      
    </div>
  
</nav>
</header>


</template>

<script>
export default {
    name: 'Header',
}
</script>

<style lang="scss" scoped>
 
 .active {
     background-color: rgba(#fff, .1);
 }

</style>