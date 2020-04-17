<template>
    <v-content>
        <v-container class="fill-height">
            <slot></slot>
        </v-container>
    </v-content>
</template>

<script>
  import {Component, Vue} from 'vue-property-decorator';

  @Component({
    name: 'DashboardContent',
  })
  export default class DashboardContent extends Vue {
  }
</script>

<style scoped>

</style>
