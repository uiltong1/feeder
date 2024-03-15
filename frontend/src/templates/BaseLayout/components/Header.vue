<template>
  <div>
    <a-page-header class="page-header" title="Feeder"> </a-page-header>
  </div>
</template>

<script>
export default {
  name: "Header",
};
</script>

<style lang="scss" scoped>
.page-header {
  border: 1px solid rgb(235, 237, 240);
  background: #fff;
}

.ant-layout-header{
  height: 64px;
    padding: 0 50px;
    color: rgba(0, 0, 0, 0.85);
    line-height: 64px;
}
</style>
