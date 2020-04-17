<template>
  <v-list-item link :href="href">
    <v-list-item-icon v-if="icon">
      <v-icon>{{ icon }}</v-icon>
    </v-list-item-icon>
    <v-list-item-title>{{ name }}</v-list-item-title>
  </v-list-item>
</template>

<script lang="ts">
import { Vue, Component } from "vue-property-decorator";

@Component({
  name: "SidebarLink",
  props: {
    icon: { type: String, required: false, default: null },
    name: { type: String, required: true },
    href: { type: String, required: true },
  },
})
export default class SidebarLink extends Vue {}
</script>
