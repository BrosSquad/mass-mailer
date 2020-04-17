<template>

</template>

<script lang="ts">
  import {Component, Vue} from 'vue-property-decorator';
  import DashboardContent from '@/components/layouts/dashboard/DashboardContent.vue';
  import Navbar from '@/components/layouts/dashboard/Navbar.vue';
  import Sidebar from '@/components/layouts/dashboard/Sidebar.vue';

  @Component({
    name: 'HelloWorld',
    components: {
      DashboardContent,
      Navbar,
      Sidebar,
    },
  })
  export default class HelloWorld extends Vue {
    public created(): void {
    }
  }
</script>
