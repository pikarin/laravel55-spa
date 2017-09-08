<template>
  <div id="app">
    <v-app toolbar footer dark>
      <v-toolbar dark>
        <v-toolbar-title>KoCak</v-toolbar-title>
      </v-toolbar>
      <main>
        <v-container>
          <v-layout>
            <v-flex xs12>
              <v-card height="300px"></v-card>
            </v-flex>
          </v-layout>
        </v-container>
      </main>
      <v-footer></v-footer>
    </v-app>
  </div>
</template>

<script>
import Example from './components/Example.vue';
export default {
  name: 'app',
  components: {
    Example,
  },
};
</script>