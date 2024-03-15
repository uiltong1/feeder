<template>
  <a-menu mode="horizontal">
    <a-menu-item key="usuarios">
      <router-link to="/usuarios">
        <TeamOutlined /> Usuários
      </router-link>
    </a-menu-item>

    <a-menu-item key="tags">
      <router-link to="/tags">
        <TagOutlined /> Tags
      </router-link>
    </a-menu-item>

    <a-menu-item key="posts">
      <router-link to="/posts">
        <FileTextOutlined /> Posts
      </router-link>
    </a-menu-item>
  </a-menu>
</template>

<script>
import { TeamOutlined, TagOutlined, FileTextOutlined } from "@ant-design/icons-vue";
export default {
  components: { TeamOutlined, TagOutlined, FileTextOutlined },
  name: "Menu",
};
</script>

<style lang="scss" scoped></style>
