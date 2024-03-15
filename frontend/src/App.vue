<template>
  <div>
    <Message />
    <BaseLayout />
  </div>
</template>
<script>
import BaseLayout from "./templates/BaseLayout";
import Message from "./modules/messages/components/Message.vue";
export default {
  components: {
    Message,
    BaseLayout,
  },
};
</script>
