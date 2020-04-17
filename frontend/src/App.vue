<template>
    <RouterView></RouterView>
</template>

<script lang="ts">
  import {Component, Vue} from 'vue-property-decorator';

  @Component({
    name: 'App',
    components: {
    },
  })
  export default class App extends Vue {
  }
</script>
