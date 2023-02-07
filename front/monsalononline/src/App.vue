


<template>
  <PageHeader />
  <router-view></router-view>
  <PageFooter />

</template>

<script>
// import axios from 'axios';
import PageHeader from './components/PageHeader.vue';
import PageFooter from './components/PageFooter.vue';

export default {
  components: {
    PageHeader,
    PageFooter
  },
  
  
};
</script>
