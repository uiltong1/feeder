<template>
  <div>
    <Table title="Posts" id="id" :columns="columns" :data="data" :loading="loading" @create="create" @consult="consult"
      @edit="edit" @remove="remove" @search="handlePage" />
    <a-modal v-model:visible="openModal" title="Formulário de Post" :confirm-loading="loading" :footer="false">
      <FormPost v-if="openModal" :key="formPostKey" :loading="sendLoading" :open-modal="openModal" :item="item"
        :users="users" :tags="tags" :isDisable="isDisable" @send="send">
      </FormPost>
    </a-modal>

  </div>
</template>
<script>
import { mapGetters } from 'vuex';
import FormPost from "../components/Form.vue"
export default {
  components: {
    FormPost
  },
  data() {
    return {
      loading: false,
      formPostKey: 0,
      openModal: false,
      isDisable: false,
      sendLoading: false,
      item: {},
      columns: [
        {
          title: "Titulo",
          dataIndex: "title",
          key: "title",
          customFilterDropdown: true,
          minWidth: 12000,
        },
        {
          title: "Usuário",
          dataIndex: "user",
          key: "user_id",
          minWidth: 12000,
          customRender: (record) => {
            return record?.record?.user?.name
          }
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
    this.loading = true;
    await this.$store.dispatch("$_tags/index");
    await this.$store.dispatch("$_users/index");
    await this.handlePage();
    this.loading = false;
  },
  computed: {
    ...mapGetters("$_posts", [
      'posts'
    ]),
    ...mapGetters("$_users", [
      'users'
    ]),
    ...mapGetters("$_tags", [
      'tags'
    ]),

  },
  methods: {
    create() {
      this.formPostKey++
      this.openModal = true;
      this.item = {};
      this.isDisable = false
    },
    edit(item) {
      this.formPostKey++
      this.openModal = true;
      this.item = item;
      this.isDisable = false
    },
    consult(item) {
      this.formPostKey++
      this.openModal = true;
      this.item = item;
      this.isDisable = true;
    },
    async update(item) {
      await this.$store.dispatch("$_posts/update", item.id);
      await this.handlePage()
    },
    async remove(id) {
      try {
        this.loading = true
        await this.$store.dispatch("$_posts/remove", id);
        await this.handlePage()
      } finally {
        this.loading = false
      }
    },
    async handlePage(filter = {}) {
      try {
        this.loading = true
        await this.$store.dispatch("$_posts/index", filter);
        this.data = this.posts
      } finally {
        this.loading = false

      }
    },
    async send(form) {
      this.sendLoading = true
      try {
        if (form?.id)
          await this.$store.dispatch("$_posts/update", form)
        else
          await this.$store.dispatch("$_posts/store", form)

        this.openModal = false
        await this.handlePage()
      } finally {
        this.sendLoading = false
      }
    }
  },
};
</script>