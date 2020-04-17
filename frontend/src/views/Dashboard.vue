<template>
    <DashboardLayout>
        <h1>Hello</h1>
    </DashboardLayout>
</template>

<script>
  import {Component, Vue} from 'vue-property-decorator';
  import DashboardLayout from '../components/layouts/dashboard/DashboardLayout';

  @Component({
    name: 'Dashboard',
    components: {
      DashboardLayout,
    },
  })
  export default class Dashboard extends Vue {

  }
</script>

<style scoped>

</style>
