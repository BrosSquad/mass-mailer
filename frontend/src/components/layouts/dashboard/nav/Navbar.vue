<template>
  <div>
    <v-app-bar color="blue accent-3" dark>
      <v-toolbar-title>
        <v-icon left>{{ mdiEmailNewsletter }}</v-icon
        >Mass Mailer
      </v-toolbar-title>

      <v-spacer></v-spacer>
      <Search />
      <v-spacer></v-spacer>
      <Menu />
    </v-app-bar>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import { mdiEmailNewsletter } from "@mdi/js";

import Menu from "./Menu";
import Search from "./Search";

@Component({
  name: "Navbar",
  components: {
    Menu,
    Search,
  },
})
export default class Navbar extends Vue {
  public data() {
    return {
      mdiEmailNewsletter,
    };
  }
}
</script>
