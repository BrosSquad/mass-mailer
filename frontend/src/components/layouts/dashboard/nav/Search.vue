<template>
  <!-- <v-autocomplete
        :loading="loading"
        :items="items"
        :search-input.sync="search"
        cache-items
        class="mx-4"
        flat
        hide-no-data
        hide-details
        label="What state are you from?"
        solo-inverted
      ></v-autocomplete> -->
  <v-autocomplete
    class="mx-4"
    flat
    hide-no-data
    hide-details
    label="Search..."
    solo-inverted
  ></v-autocomplete>
</template>

<script lang="ts">
import { Vue, Component } from "vue-property-decorator";

@Component({
  name: "Search",
})
export default class Search extends Vue {}
</script>
