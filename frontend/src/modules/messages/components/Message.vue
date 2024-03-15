<template>
  <a-modal :closable="false" :cancel="false" v-model:visible="messagesExist" :footer="null">
    <div v-if="messages.type == 'error'" style="text-align: center">
      <p>
        <CloseCircleOutlined :style="{ fontSize: '40px', color: 'red' }" />
      </p>
      <h1>Erro!</h1>
      <span :style="{ fontSize: '18px', margin: '20px' }">
        {{ messages.message }}</span>
      <template v-if="messages?.errors">
        <li v-for=" (item, index) in messages?.errors" :key="index">
          {{ item?.error }}
        </li>
      </template>
    </div>
    <div v-else style="text-align: center">
      <template v-if="messages.type == 'success'">
        <p>
          <CheckCircleOutlined :style="{ fontSize: '40px', color: 'green' }" />
        </p>
        <h1>Sucesso!</h1>
      </template>
      <template v-if="messages.type == 'attention'">
        <p>
          <ExclamationCircleOutlined :style="{ fontSize: '40px', color: 'orange' }" />
        </p>
        <h1>Atenção!</h1>
      </template>

      <span :style="{ fontSize: '18px', margin: '20px' }">
        {{ messages.message }}</span>
    </div>
    <div :style="{ textAlign: 'center', margin: '20px' }">
      <a-button type="primary" @click="handleOk">OK</a-button>
    </div>
  </a-modal>
</template>
<script>
import _ from "lodash";
import store from "../_store";
import { mapGetters } from "vuex";
import {
  CloseCircleOutlined,
  CheckCircleOutlined,
  ExclamationCircleOutlined,
} from "@ant-design/icons-vue";

export default {
  components: {
    CloseCircleOutlined,
    CheckCircleOutlined,
    ExclamationCircleOutlined,
  },
  beforeMount() {
    const STORE_KEY = "$_messages";
    if (!(STORE_KEY in this.$store._modules.root._children)) {
      this.$store.registerModule(STORE_KEY, store);
    }
  },
  computed: {
    ...mapGetters({
      messages: "$_messages/messages",
    }),
    messagesExist() {
      if (!_.isEmpty(this.messages)) return true;
      else return false;
    },
  },
  methods: {
    handleOk() {
      this.$store.dispatch("$_messages/destroyMessages");
    },
  },
};
</script>