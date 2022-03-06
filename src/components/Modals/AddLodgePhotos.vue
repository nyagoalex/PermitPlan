<!-- @format -->

<template>
    <b-modal id="lodge-photo-modal" title="Add Photos" size="lg" @hide="hide()">
        <input
            type="file"
            accept="image/*"
            id="files"
            ref="files"
            multiple
            v-on:change="filesChange()"
            v-show="false"
        />
        <div class="row px-2" style="max-height: 450px; overflow-y: auto">
            <b-table-simple>
                <b-thead head-variant="dark">
                    <b-tr>
                        <b-th>#</b-th>
                        <b-th>Image</b-th>
                        <b-th>Title</b-th>
                        <b-th>Description</b-th>
                        <b-th colspan="2">Action</b-th>
                    </b-tr>
                </b-thead>
                <b-tbody>
                    <tr
                        v-for="(data, index) in rowData"
                        :key="index"
                        :class="{ uploaded: data.uploaded }"
                    >
                        <td>{{ index + 1 }}</td>
                        <td>
                            <img v-lazy="preview(data.photo)" width="70" height="70" />
                        </td>
                        <td>
                            <input
                                type="text"
                                class="form-control"
                                v-model="data.title"
                                :disabled="data.uploaded"
                                :class="{ 'is-invalid': data.errors.title }"
                            />
                            <ul
                                class="list-unstyled invalid-feedback"
                                v-if="data.errors.title"
                            >
                                <li v-for="error in data.errors.title" :key="error">
                                    {{ error }}
                                </li>
                            </ul>
                        </td>
                        <td>
                            <textarea
                                class="form-control"
                                v-model="data.description"
                                :disabled="data.uploaded"
                                :class="{ 'is-invalid': data.errors.description }"
                            ></textarea>
                            <ul
                                class="list-unstyled invalid-feedback"
                                v-if="data.errors.description"
                            >
                                <li v-for="error in data.errors.description" :key="error">
                                    {{ error }}
                                </li>
                            </ul>
                        </td>
                        <td>
                            <b-button
                                variant="success"
                                pill
                                title="Upload Photo"
                                @click="uploadPhoto(index)"
                                v-if="!data.uploaded"
                            >
                                <b-icon icon="cloud-upload"></b-icon>
                            </b-button>
                        </td>
                        <td>
                            <b-button
                                variant="danger"
                                title="Remove Photo"
                                pill
                                @click="rowData.splice(index, 1)"
                                v-if="!data.uploaded"
                            >
                                <b-icon icon="trash"></b-icon>
                            </b-button>
                        </td>
                    </tr>
                </b-tbody>
            </b-table-simple>

            <!-- <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" v-model="agent.email" placeholder="myemail@example.com" :class="{ 'is-invalid': errors.email}">
                    <ul class="list-unstyled invalid-feedback" v-if="errors.email">
                        <li v-for="(error) in errors.email" :key="error">{{ error }}</li>
                    </ul>
                </div> -->
        </div>
        <template v-slot:modal-footer="{ cancel }">
            <b-progress
                max="100"
                :value="uploadPercentage"
                class="w-50 mb-2"
                show-progress
                animated
                :variant="progressVariant"
            ></b-progress>
            <b-button size="sm" variant="secondary" @click="cancel()">Cancel</b-button>
            <b-button size="sm" variant="primary" @click="$refs.files.click()"
                >Add Photos</b-button
            >
        </template>
    </b-modal>
</template>

<script>
export default {
    data() {
        return {
            files: [],
            rowData: [],
            uploadPercentage: 0,
            progressVariant: 'success',
            photo_added: false
        }
    },
    props: {
        hidingModal: Function
    },
    methods: {
        hide() {
            this.hidingModal(this.photo_added)
            this.photo_added = false
        },
        preview(file) {
            return URL.createObjectURL(file)
        },
        filesChange() {
            const uploadedFiles = this.$refs.files.files
            for (var i = 0; i < uploadedFiles.length; i++) {
                const row = {
                    errors: [],
                    uploaded: false,
                    title: '',
                    description: '',
                    photo: uploadedFiles[i]
                }
                this.rowData.push(row)
            }
        },
        uploadPhoto(index) {
            this.uploadPercentage = 0
            this.progressVariant = 'success'
            const param = this.rowData[index]
            const formData = new FormData()
            formData.append('photo', param.photo)
            formData.append('title', param.title)
            formData.append('description', param.description)

            this.$http
                .post('/lodges/' + this.$route.params.id + '/photos', formData, {
                    onUploadProgress: function (progressEvent) {
                        this.uploadPercentage = parseInt(
                            Math.round((progressEvent.loaded / progressEvent.total) * 100)
                        )
                    }.bind(this)
                })
                .then((photos) => {
                    param.uploaded = true
                    param.errors = []
                    this.$set(this.rowData, index, param)
                    this.alertAddSuccess()
                    this.photo_added = true
                })
                .catch((errors) => {
                    param.errors = errors.errors
                    param.uploaded = false
                    this.$set(this.rowData, index, param)
                    this.toastError(errors.message)
                    this.progressVariant = 'danger'
                })
        }
    }
}
</script>
>

<style>
.uploaded {
    background-color: #f1f1eb;
    cursor: not-allowed;
}
</style>
