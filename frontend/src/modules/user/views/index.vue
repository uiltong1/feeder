<template>
  <div>
    <Table :title="'Usuários'" id="id" :columns="columns" :data="data" :loading="loading" @create="create"
      @consult="consult" @edit="edit" @remove="remove" @search="handlePage" />
    <a-modal v-model:visible="openModal" title="Formulário de usuário" :confirm-loading="loading" :footer="false">
      <FormUser v-if="openModal" :key="formUserKey" :loading="sendLoading" :open-modal="openModal" :item="item"
        :isDisable="isDisable" @send="send">
      </FormUser>
    </a-modal>

  </div>
</template>
<script>
import { mapGetters } from 'vuex';
import FormUser from "../components/Form.vue"
export default {
  components: {
    FormUser
  },
  data() {
    return {
      loading: false,
      formUserKey: 0,
      openModal: false,
      isDisable: false,
      sendLoading: false,
      item: {},
      columns: [
        {
          title: "Nome",
          dataIndex: "name",
          key: "name",
          customFilterDropdown: true,
          minWidth: 12000,
        },
        {
          title: "E-mail",
          dataIndex: "email",
          key: "email",
          customFilterDropdown: true,
        },
        {
          key: "action",
          onConsult: true,
          onEdit: true,
          onDelete: true,
          width: 150,
        },
      ],
      data: [],
    };
  },
  async mounted() {
    await this.handlePage()
  },
  computed: {
    ...mapGetters("$_users", [
      'users'
    ]),
  },
  methods: {
    create() {
      this.formUserKey++
      this.openModal = true;
      this.item = {};
      this.isDisable = false
    },
    edit(item) {
      this.formUserKey++
      this.openModal = true;
      this.item = item;
      this.isDisable = false
    },
    consult(item) {
      this.formUserKey++
      this.openModal = true;
      this.item = item;
      this.isDisable = true;
    },
    async update(item) {
      await this.$store.dispatch("$_users/update", item.id);
      await this.handlePage()
    },
    async remove(id) {
      try {
        this.loading = true
        await this.$store.dispatch("$_users/remove", id);
        await this.handlePage()
      } finally {
        this.loading = false
      }
    },
    async handlePage(filter = {}) {
      try {
        this.loading = true
        await this.$store.dispatch("$_users/index", filter);
        this.data = this.users
      } finally {
        this.loading = false

      }
    },
    async send(form) {
      this.sendLoading = true
      try {
        if (form?.id)
          await this.$store.dispatch("$_users/update", form)
        else
          await this.$store.dispatch("$_users/store", form)

        this.openModal = false
        await this.handlePage()
      } finally {
        this.sendLoading = false
      }
    }
  },
};
</script>