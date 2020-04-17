<template>
</template>

<script lang="ts">

  import {Component, Vue} from 'vue-property-decorator';

  @Component({
    name: 'DashboardSidebar',
  })
  export default class DashboardSidebar extends Vue {
    public data() {
      return {
        items: [
          { icon: 'mdi-trending-up', text: 'Most Popular' },
          { icon: 'mdi-youtube-subscription', text: 'Subscriptions' },
          { icon: 'mdi-history', text: 'History' },
          { icon: 'mdi-playlist-play', text: 'Playlists' },
          { icon: 'mdi-clock', text: 'Watch Later' },
        ],
        items2: [
          { picture: 28, text: 'Joseph' },
          { picture: 38, text: 'Apple' },
          { picture: 48, text: 'Xbox Ahoy' },
          { picture: 58, text: 'Nokia' },
          { picture: 78, text: 'MKBHD' },
        ],
      }
    }
  }
</script>
