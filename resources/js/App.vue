<template>
  <v-app>
    <v-navigation-drawer
      v-model="drawer"
      :mini-variant="miniVariant"
      :clipped="clipped"
      fixed
      app
    >
      <v-list>
        <v-list-item
          v-for="(item, i) in drawerLinks"
          :key="i"
          :to="item.to"
          exact
        >
          <v-list-item-action>
            <v-icon>
              {{ item.icon }}
            </v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title v-text="item.title" />
          </v-list-item-content>
        </v-list-item>

        <v-list-item href="/">
          <v-list-item-action>
            <v-icon>
              mdi-logout-variant
            </v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>
              Logout
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-app-bar
      :clipped-left="clipped"
      fixed
      app
    >
      <v-app-bar-nav-icon @click.stop="miniVariant = !miniVariant" />
      
      <v-toolbar-title v-text="headerTitle" />
      <v-spacer />
      <v-switch 
        inset
        class="pt-5" 
        style="width:105px" 
        v-model="darkmode"
        prepend-icon="mdi-white-balance-sunny" 
        append-icon="mdi-weather-night"
      >
      </v-switch>
    </v-app-bar>

    <v-main>
      <v-container>
        <router-view></router-view>
      </v-container>
    </v-main>

    <v-footer 
      app
      fixed
      elevation="12"
      :height="60"
    >
      <div>
        <v-icon dense>
          mdi-copyright
        </v-icon>
        {{ footerLabel }}
      </div>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  name: 'App',
  data: () => ({
    clipped: true,
    drawer: true,
    darkmode: false,
    miniVariant: false,
    right: true,
  }),
  created() {
    /* remove this for standalone system */
    this.$store.dispatch('login')
    /* End */
    this.$store.dispatch('getStoredState')
    this.darkmode = this.$store.state.darkmode.darkMode
    this.$vuetify.theme.dark = this.$store.state.darkmode.darkMode
  },
  watch: {
    darkmode(newval, oldval) {
      this.darkmode = newval
      this.switchTheme(newval)
    }
  },
  methods: {
    switchTheme () {
      this.$store.dispatch('changeStoredState', this.darkmode)
      this.$vuetify.theme.dark = this.darkmode
    }
  },
  computed: {
    headerTitle() {
      let title = ''

      switch(this.$route.name) {
        case 'admin':
          title = 'Maintenance Panel'; 
          break;
        case 'customer':
          title = 'Customer Panel';
          break;
        default:
          title = '404 Not Found';
      }

      return title
    },
    drawerLinks() {
      let items = []

      switch(this.$route.name) {
        case 'admin':
          items = [
            {
              icon: 'mdi-view-dashboard-outline',
              title: 'Dashboard',
              to: '#1'
            },
            {
              icon: 'mdi-playlist-edit',
              title: 'Edit Menu',
              to: '#2'
            },
            {
              icon: 'mdi-playlist-plus',
              title: 'New Menu',
              to: '#3'
            },
          ] 
          break;

        default:
          items = [
            {
              icon: 'mdi-view-dashboard-outline',
              title: 'Dashboard',
              to: '#1'
            },
            {
              icon: 'mdi-order-bool-ascending-variant',
              title: 'Order',
              to: '#2'
            },
            {
              icon: 'mdi-view-list-outline',
              title: 'View',
              to: '#3'
            },
          ] 
      }

      return items
    },
    footerLabel() {
      return new Date().getFullYear() + ' - Gene Arthur'
    },
  }
}
</script>
