<template>
  <section class="container">
      
      <div v-if="post">
          <h1>{{ post.title }}</h1>

          <h4 v-if="post.category">Category: {{ post.category.name }} </h4>
          <h4 v-else>Uncategorized</h4>

          <!-- <div class="mb-5">
              <span 
                  v-for="tag in post.tags"
                  :key="`tag-${tag.id}`"
                  class="badge badge-primary"
                  >
                  {{ tag.name}}

              </span>
          </div> -->
          <Tags class="mb-5" :list="post.tags"/>

          <figure v-if="post.cover">
              <img :src="post.cover" :alt="post.title">
          </figure>

          <p> {{ post.content }}</p>
      </div>
      <Loader text="Loading post" v-else />


  </section>
</template>

<script>
import axios from 'axios';
import Loader from '../components/Loader';
import Tags from '../components/Tags';

export default {
    name: 'PostDetail',
    components: {
        Loader,
        Tags,
    },
    data() {
        return {
            post: null,
        }
    },
    created() {
        this.getPostDetail();
    },
    methods: {
        getPostDetail() {
            axios.get(`http://127.0.0.1:8000/api/posts/${this.$route.params.slug}`)
                 .then(res => {
                     console.log(res.data);
                     

                     if(res.data.not_found) {
                         this.$router.push({ name: 'not-found'})
                     }else{
                         this.post = res.data;
                     }
                 })
                 .catch(err => log.error(err));
        }
    }
}
</script>

<style>

</style>