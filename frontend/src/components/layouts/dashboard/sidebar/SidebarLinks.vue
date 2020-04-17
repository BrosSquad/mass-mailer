<template>
  <v-list nav dense>
    <SidebarLink
      :name="link.name"
      :icon="link.icon"
      :href="link.href"
      v-for="(link, index) of links"
      :key="index"
    ></SidebarLink>
  </v-list>
</template>

<script lang="ts">
import { Vue, Component } from "vue-property-decorator";
import {
  mdiApplication,
  mdiSignatureFreehand,
  mdiMessage,
  mdiKey,
  mdiKeyOutline,
  mdiAccountBox,
} from "@mdi/js";

import SidebarLink from "./SidebarLink";
@Component({
  name: "SidebarLinks",
  components: {
    SidebarLink,
  },
})
export default class SidebarLinks extends Vue {
  public data() {
    return {
      links: [
        {
          icon: mdiApplication,
          name: "Applications",
          href: "/dashboard/applications",
        },
        {
          icon: mdiSignatureFreehand,
          name: "Subscribers",
          href: "/dashboard/subscribers",
        },
        { icon: mdiMessage, name: "Messages", href: "/dashboard/messages" },
        { icon: mdiKey, name: "Application Keys", href: "/dashboard/app-keys" },
        {
          icon: mdiKeyOutline,
          name: "SendGrid Keys",
          href: "/dashboard/sendgrid-keys",
        },
        { icon: mdiAccountBox, name: "Users", href: "/dashboard/users" },
      ],
    };
  }
}
</script>
