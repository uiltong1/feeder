<template>
  <div>
    <Table :title="'Tags'" id="id" :columns="columns" :data="data" :loading="loading" @create="create" @consult="consult"
      @edit="edit" @remove="remove" @search="handlePage" />
    <a-modal v-model:visible="openModal" title="Formulário de Tag" :confirm-loading="loading" :footer="false">
      <FormTag v-if="openModal" :key="formTagKey" :loading="sendLoading" :open-modal="openModal" :item="item"
        :isDisable="isDisable" @send="send">
      </FormTag>
    </a-modal>

  </div>
</template>
<script>
import { mapGetters } from 'vuex';
import FormTag from "../components/Form.vue"
export default {
  components: {
    FormTag
  },
  data() {
    return {
      loading: false,
      formTagKey: 0,
      openModal: false,
      isDisable: false,
      sendLoading: false,
      item: {},
      columns: [
        {
          title: "Tag",
          dataIndex: "slug",
          key: "slug",
          customFilterDropdown: true,
          minWidth: 12000,
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
    ...mapGetters("$_tags", [
      'tags'
    ]),
  },
  methods: {
    create() {
      this.formTagKey++
      this.openModal = true;
      this.item = {};
      this.isDisable = false
    },
    edit(item) {
      this.formTagKey++
      this.openModal = true;
      this.item = item;
      this.isDisable = false
    },
    consult(item) {
      this.formTagKey++
      this.openModal = true;
      this.item = item;
      this.isDisable = true;
    },
    async update(item) {
      await this.$store.dispatch("$_tags/update", item.id);
      await this.handlePage()
    },
    async remove(id) {
      try {
        this.loading = true
        await this.$store.dispatch("$_tags/remove", id);
        await this.handlePage()
      } finally {
        this.loading = false
      }
    },
    async handlePage(filter = {}) {
      try {
        this.loading = true
        await this.$store.dispatch("$_tags/index", filter);
        this.data = this.tags
      } finally {
        this.loading = false

      }
    },
    async send(form) {
      this.sendLoading = true
      try {
        if (form?.id)
          await this.$store.dispatch("$_tags/update", form)
        else
          await this.$store.dispatch("$_tags/store", form)

        this.openModal = false
        await this.handlePage()
      } finally {
        this.sendLoading = false
      }
    }
  },
};
</script>