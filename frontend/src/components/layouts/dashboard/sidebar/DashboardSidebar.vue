<template>
  <v-navigation-drawer
    permanent
    :mini-variant="drawerMini"
    :expand-on-hover="drawerMini"
  >
    <SidebarProfile />
    <v-divider></v-divider>

    <SidebarLinks />
  </v-navigation-drawer>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import { mapState } from "vuex";

import SidebarProfile from "./SidebarProfile";
import SidebarLinks from "./SidebarLinks";

@Component({
  name: "DashboardSidebar",
  computed: {
    ...mapState({
      drawerMini: (state: any) => state.theme.drawerMini,
    }),
  },
  components: {
    SidebarProfile,
    SidebarLinks,
  },
})
export default class DashboardSidebar extends Vue {
  public data() {
    return {};
  }
}
</script>
