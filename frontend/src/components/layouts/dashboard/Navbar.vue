<template>
    <div>
        <v-app-bar color="blue accent-3" dark>
            <v-app-bar-nav-icon></v-app-bar-nav-icon>

            <v-toolbar-title>
                <v-icon>mdi-heart</v-icon>
                Mass Mailer
            </v-toolbar-title>

            <v-spacer></v-spacer>


            <v-toolbar-items>
                <v-divider
                        inset
                        vertical
                ></v-divider>


                <v-avatar
                        size="60px"
                >
                    <img
                            alt="Avatar"
                            src="https://avatars0.githubusercontent.com/u/9064066?v=4&s=460"
                    >
                </v-avatar>
                <v-menu bottom left>
                    <template v-slot:activator="{ on }">
                        <v-btn
                                dark
                                icon
                                v-on="on"
                        >
                            <v-icon>mdi-dots-vertical</v-icon>
                        </v-btn>
                    </template>
                    <v-list>
                        <v-list-item>
                            <v-list-item-title>Profile</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>Logout</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>

                <v-divider
                        inset
                        vertical
                ></v-divider>
            </v-toolbar-items>
        </v-app-bar>
    </div>
</template>


<script lang="ts">
  import {Component, Vue} from 'vue-property-decorator';
  // import {mdiAccount} from '@mdi/js';

  @Component({
    name: 'Navbar',
  })
  export default class Navbar extends Vue {
    public data = () => ({
    });
  }

</script>
