<template>
  <a-layout id="layout">
    <Header />
    <Menu />
    <a-layout>
      <a-layout style="padding: 0">
        <a-layout-content class="content">
          <router-view />
        </a-layout-content>
      </a-layout>
    </a-layout>
  </a-layout>
</template>
<script>
import Header from "./components/Header.vue";
import Menu from "./components/Menu.vue";
export default {
  components: { Menu, Header },
};
</script>

<style lang="scss">
.content {
  background: #fff;
  padding: 20px;
  margin: 0;
}
</style>
