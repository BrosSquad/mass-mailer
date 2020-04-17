<template>
    <v-app id="inspire" dark>
        <Navbar/>
        <DashboardSidebar/>
        <DashboardContent/>
    </v-app>
</template>

<script>
  import {Component, Vue} from 'vue-property-decorator';
  import DashboardSidebar from './DashboardSidebar';
  import Navbar from './Navbar';
  import DashboardContent from './DashboardContent';

  @Component({
    name: 'DashboardLayout',
    components: {
      DashboardSidebar,
      DashboardContent,
      Navbar,
    },
  })
  export default class DashboardLayout extends Vue {
  };
</script>
