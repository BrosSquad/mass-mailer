<template>
  <v-toolbar-items>
    <v-btn icon dark class="mr-12 mt-1">
      <v-badge color="pink" content="0">
        <v-icon>{{ mdiBell }} </v-icon>
      </v-badge>
    </v-btn>

    <v-divider inset vertical></v-divider>
    <v-btn dark icon class="mx-5" style="min-width: 200px">
      <v-avatar size="48px" class="mr-4">
        <img
          alt="Avatar"
          src="https://avatars0.githubusercontent.com/u/9064066?v=4&s=460"
        />
      </v-avatar>
      Dusan Malusev
    </v-btn>

    <v-divider inset vertical></v-divider>

    <v-menu bottom left>
      <template v-slot:activator="{ on }">
        <v-btn dark icon v-on="on">
          <v-icon>mdi-dots-vertical</v-icon>
        </v-btn>
      </template>
      <v-list>
        <v-list-item>
          <v-list-item-title>
            <v-icon>{{ mdiAccount }}</v-icon> Profile
          </v-list-item-title>
        </v-list-item>
        <v-list-item>
          <v-list-item-title>
            <v-icon>{{ mdiLogout }}</v-icon> Logout
          </v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>

    <v-divider inset vertical></v-divider>
  </v-toolbar-items>
</template>

<script lang="ts">
import { Vue, Component } from "vue-property-decorator";
import { mdiEmailNewsletter, mdiBell, mdiLogout, mdiAccount } from "@mdi/js";

@Component({
  name: "Menu",
})
export default class Menu extends Vue {
    public data() {
    return {
      mdiBell,
      mdiAccount,
      mdiLogout,
    };
  }
}  
</script>
