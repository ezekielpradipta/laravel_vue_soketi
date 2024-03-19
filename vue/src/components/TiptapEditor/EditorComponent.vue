<template>
  <div class="divide-y divide-gray-400 border border-gray-400">
    <div class="divide-x">
      <!-- Redo Undo -->
      <TipTapToolbarGroup>
        <TipTapToolbarButton
          label="Undo"
          @click="editorInstance?.chain().focus().undo().run()"
          :disabled="!editorInstance?.can().chain().focus().undo().run()"
        >
          <IconArrowBackUp class="h-5 w-5" />
        </TipTapToolbarButton>
        <TipTapToolbarButton
          label="Redo"
          @click="editorInstance?.chain().focus().redo().run()"
          :disabled="!editorInstance?.can().chain().focus().redo().run()"
        >
          <IconArrowForwardUp class="h-5 w-5" />
        </TipTapToolbarButton>
      </TipTapToolbarGroup>
      <!-- Heading -->
      <TipTapToolbarGroup>
        <TipTapToolbarButton
          label="Heading 1 "
          :is-active="editorInstance?.isActive('heading', { level: 1 })"
          @click="editorInstance?.chain().focus().toggleHeading({ level: 1 }).run()"
        >
          <IconH1 class="h-5 w-5" />
        </TipTapToolbarButton>
        <TipTapToolbarButton
          label="Heading 2"
          :is-active="editorInstance?.isActive('heading', { level: 2 })"
          @click="editorInstance?.chain().focus().toggleHeading({ level: 2 }).run()"
        >
          <IconH2 class="h-5 w-5" />
        </TipTapToolbarButton>
        <TipTapToolbarButton
          label="Heading 3"
          :is-active="editorInstance?.isActive('heading', { level: 3 })"
          @click="editorInstance?.chain().focus().toggleHeading({ level: 3 }).run()"
        >
          <IconH3 class="h-5 w-5" />
        </TipTapToolbarButton>
      </TipTapToolbarGroup>
      <!-- Font -->
      <TipTapToolbarGroup>
        <TipTapToolbarButton
          label="Bold"
          :is-active="editorInstance?.isActive('bold')"
          @click="editorInstance?.chain().focus().toggleBold().run()"
        >
          <IconBold class="h-5 w-5" />
        </TipTapToolbarButton>
        <TipTapToolbarButton
          label="Italic"
          :is-active="editorInstance?.isActive('italic')"
          @click="editorInstance?.chain().focus().toggleItalic().run()"
        >
          <IconItalic class="h-5 w-5" />
        </TipTapToolbarButton>
        <TipTapToolbarButton
          label="Underline"
          :is-active="editorInstance?.isActive('underline')"
          @click="editorInstance?.chain().focus().toggleUnderline().run()"
        >
          <IconUnderline class="h-5 w-5" />
        </TipTapToolbarButton>
        <TipTapToolbarButton
          label="Strike"
          :is-active="editorInstance?.isActive('strike')"
          @click="editorInstance?.chain().focus().toggleStrike().run()"
        >
          <IconStrikethrough class="h-5 w-5" />
        </TipTapToolbarButton>
      </TipTapToolbarGroup>
      <!-- SUb sup -->
      <TipTapToolbarGroup>
        <TipTapToolbarButton
          label="Subscript"
          :is-active="editorInstance?.isActive('subscript')"
          @click="editorInstance?.chain().focus().toggleSubscript().run()"
        >
          <span>Sub</span>
        </TipTapToolbarButton>
        <TipTapToolbarButton
          label="SuperScript"
          :is-active="editorInstance?.isActive('superscript')"
          @click="editorInstance?.chain().focus().toggleSuperscript().run()"
        >
          <span>Sup</span>
        </TipTapToolbarButton>
      </TipTapToolbarGroup>
      <!-- Numbering -->
      <TipTapToolbarGroup>
        <TipTapToolbarButton
          label="Bullet"
          :is-active="editorInstance?.isActive('bulletList')"
          @click="editorInstance?.chain().focus().toggleBulletList().run()"
        >
          <IconListDetails class="h-5 w-5" />
        </TipTapToolbarButton>
        <TipTapToolbarButton
          label="Ordered"
          :is-active="editorInstance?.isActive('orderedList')"
          @click="editorInstance?.chain().focus().toggleOrderedList().run()"
        >
          <IconListNumbers class="h-5 w-5" />
        </TipTapToolbarButton>
      </TipTapToolbarGroup>
      <!-- Text Align -->
      <TipTapToolbarGroup>
        <TipTapToolbarButton
          label="Left Align"
          :is-active="editorInstance?.isActive({ textAlign: 'left' })"
          @click="editorInstance?.chain().focus().setTextAlign('left').run()"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-5 h-5"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12"
            />
          </svg>
        </TipTapToolbarButton>
        <TipTapToolbarButton
          label="Center Align"
          :is-active="editorInstance?.isActive({ textAlign: 'center' })"
          @click="editorInstance?.chain().focus().setTextAlign('center').run()"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="w-5 h-5"
          >
            <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
        </TipTapToolbarButton>
        <TipTapToolbarButton
          label="Right Align"
          :is-active="editorInstance?.isActive({ textAlign: 'right' })"
          @click="editorInstance?.chain().focus().setTextAlign('right').run()"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-6 h-6"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25"
            />
          </svg>
        </TipTapToolbarButton>
      </TipTapToolbarGroup>
      <!-- Ekstensi -->
      <TipTapToolbarGroup>
        <TipTapToolbarButton
          label="BlockQuote"
          :is-active="editorInstance?.isActive('blockquote')"
          @click="editorInstance?.chain().focus().toggleBlockquote().run()"
        >
          <IconBlockquote class="h-5 w-5" />
        </TipTapToolbarButton>
        <TipTapToolbarButton label="Table" @click="toggleModalTable">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            class="h-5 w-5"
            fill="currentColor"
          >
            <path
              d="M5,4H19A2,2 0 0,1 21,6V18A2,2 0 0,1 19,20H5A2,2 0 0,1 3,18V6A2,2 0 0,1 5,4M5,8V12H11V8H5M13,8V12H19V8H13M5,14V18H11V14H5M13,14V18H19V14H13Z"
            />
          </svg>
        </TipTapToolbarButton>
        <TipTapToolbarButton
          label="HR"
          @click="editorInstance?.chain().focus().setHorizontalRule().run()"
        >
          <IconMinus class="h-5 w-5" />
        </TipTapToolbarButton>
      </TipTapToolbarGroup>
      <!-- Table Active -->
      <TipTapToolbarGroup v-if="editorInstance?.isActive('table')">
        <TipTapToolbarButton label="Remove Table" @click="editorInstance?.commands.deleteTable()">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            class="h-5 w-5"
            fill="currentColor"
          >
            <path
              d="M15.46,15.88L16.88,14.46L19,16.59L21.12,14.46L22.54,15.88L20.41,18L22.54,20.12L21.12,21.54L19,19.41L16.88,21.54L15.46,20.12L17.59,18L15.46,15.88M4,3H18A2,2 0 0,1 20,5V12.08C18.45,11.82 16.92,12.18 15.68,13H12V17H13.08C12.97,17.68 12.97,18.35 13.08,19H4A2,2 0 0,1 2,17V5A2,2 0 0,1 4,3M4,7V11H10V7H4M12,7V11H18V7H12M4,13V17H10V13H4Z"
            />
          </svg>
        </TipTapToolbarButton>
        <TipTapToolbarButton
          label="Add Column Before"
          @click="editorInstance?.commands.addColumnBefore()"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            class="h-5 w-5"
            fill="currentColor"
          >
            <path
              d="M13,2A2,2 0 0,0 11,4V20A2,2 0 0,0 13,22H22V2H13M20,10V14H13V10H20M20,16V20H13V16H20M20,4V8H13V4H20M9,11H6V8H4V11H1V13H4V16H6V13H9V11Z"
            />
          </svg>
        </TipTapToolbarButton>
        <TipTapToolbarButton
          label="Add Column After"
          @click="editorInstance?.commands.addColumnAfter()"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            class="h-5 w-5"
            fill="currentColor"
          >
            <path
              d="M11,2A2,2 0 0,1 13,4V20A2,2 0 0,1 11,22H2V2H11M4,10V14H11V10H4M4,16V20H11V16H4M4,4V8H11V4H4M15,11H18V8H20V11H23V13H20V16H18V13H15V11Z"
            />
          </svg>
        </TipTapToolbarButton>
        <TipTapToolbarButton label="Remove Column" @click="editorInstance?.commands.deleteColumn()">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            class="h-5 w-5"
            fill="currentColor"
          >
            <path
              d="M4,2H11A2,2 0 0,1 13,4V20A2,2 0 0,1 11,22H4A2,2 0 0,1 2,20V4A2,2 0 0,1 4,2M4,10V14H11V10H4M4,16V20H11V16H4M4,4V8H11V4H4M17.59,12L15,9.41L16.41,8L19,10.59L21.59,8L23,9.41L20.41,12L23,14.59L21.59,16L19,13.41L16.41,16L15,14.59L17.59,12Z"
            />
          </svg>
        </TipTapToolbarButton>
        <TipTapToolbarButton
          label="Add Row Before"
          @click="editorInstance?.commands.addRowBefore()"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            class="h-5 w-5"
            fill="currentColor"
          >
            <path
              d="M22,14A2,2 0 0,0 20,12H4A2,2 0 0,0 2,14V21H4V19H8V21H10V19H14V21H16V19H20V21H22V14M4,14H8V17H4V14M10,14H14V17H10V14M20,14V17H16V14H20M11,10H13V7H16V5H13V2H11V5H8V7H11V10Z"
            />
          </svg>
        </TipTapToolbarButton>
        <TipTapToolbarButton label="Add Row After" @click="editorInstance?.commands.addRowAfter()">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            class="h-5 w-5"
            fill="currentColor"
          >
            <path
              d="M22,10A2,2 0 0,1 20,12H4A2,2 0 0,1 2,10V3H4V5H8V3H10V5H14V3H16V5H20V3H22V10M4,10H8V7H4V10M10,10H14V7H10V10M20,10V7H16V10H20M11,14H13V17H16V19H13V22H11V19H8V17H11V14Z"
            />
          </svg>
        </TipTapToolbarButton>
        <TipTapToolbarButton label="Remove Row" @click="editorInstance?.commands.deleteRow()">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            class="h-5 w-5"
            fill="currentColor"
          >
            <path
              d="M9.41,13L12,15.59L14.59,13L16,14.41L13.41,17L16,19.59L14.59,21L12,18.41L9.41,21L8,19.59L10.59,17L8,14.41L9.41,13M22,9A2,2 0 0,1 20,11H4A2,2 0 0,1 2,9V6A2,2 0 0,1 4,4H20A2,2 0 0,1 22,6V9M4,9H8V6H4V9M10,9H14V6H10V9M16,9H20V6H16V9Z"
            />
          </svg>
        </TipTapToolbarButton>
        <TipTapToolbarButton
          label="Merger or Split Cell"
          @click="editorInstance?.commands.mergeOrSplit()"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            class="h-5 w-5"
            fill="currentColor"
          >
            <path
              d="M5,10H3V4H11V6H5V10M19,18H13V20H21V14H19V18M5,18V14H3V20H11V18H5M21,4H13V6H19V10H21V4M8,13V15L11,12L8,9V11H3V13H8M16,11V9L13,12L16,15V13H21V11H16Z"
            />
          </svg>
        </TipTapToolbarButton>
      </TipTapToolbarGroup>
    </div>
  </div>
  <!-- Editor Main -->

  <div class="flex flex-col">
    <EditorContent :editor="editorInstance" />

    <div class="mx-4 dark:text-gray-400" v-if="props.count">
      {{ editorInstance?.storage.characterCount.characters() }} huruf,
      {{ editorInstance?.storage.characterCount.words() }} kata
    </div>
  </div>
</template>

<script setup>
import { onBeforeUnmount, onMounted, ref, watchEffect } from 'vue'
import { EditorContent, useEditor } from '@tiptap/vue-3'
import TipTapToolbarGroup from './TipTapToolbarGroup.vue'
import TipTapToolbarButton from './TipTapToolbarButton.vue'
// Ekstensi
import Paragraph from '@tiptap/extension-paragraph'
import Document from '@tiptap/extension-document'
import Text from '@tiptap/extension-text'
import History from '@tiptap/extension-history'
import Heading from '@tiptap/extension-heading'
import Bold from '@tiptap/extension-bold'
import Italic from '@tiptap/extension-italic'
import Underline from '@tiptap/extension-underline'
import Strike from '@tiptap/extension-strike'
import ListItem from '@tiptap/extension-list-item'
import BulletList from '@tiptap/extension-bullet-list'
import OrderedList from '@tiptap/extension-ordered-list'
import Subscript from '@tiptap/extension-subscript'
import Superscript from '@tiptap/extension-superscript'
import TextAlign from '@tiptap/extension-text-align'

import { Blockquote } from '@tiptap/extension-blockquote'
import { HardBreak } from '@tiptap/extension-hard-break'
import { CharacterCount } from '@tiptap/extension-character-count'
import Dropcursor from '@tiptap/extension-dropcursor'
import { HorizontalRule } from '@tiptap/extension-horizontal-rule'

import Gapcursor from '@tiptap/extension-gapcursor'
import '@/css/Tiptap.css'
import {
  IconArrowBackUp,
  IconArrowForwardUp,
  IconBlockquote,
  IconBold,
  IconH1,
  IconH2,
  IconH3,
  IconItalic,
  IconListDetails,
  IconListNumbers,
  IconStrikethrough,
  IconUnderline,
  IconMinus
} from '@tabler/icons-vue'
const emit = defineEmits(['update:modelValue'])
const props = defineProps({
  modelValue: {
    type: String,
    default: ''
  },
  count: {
    type: Boolean,
    default: true
  }
})
const contentResult = ref('')
const showAddTableDialog = ref(false)

const editorInstance = useEditor({
  content: props.modelValue,
  editorProps: {
    attributes: {
      class: 'blog  '
    }
  },
  extensions: [
    Paragraph,
    Document,
    Text,
    History,
    Heading.configure({
      levels: [1, 2, 3]
    }),
    Bold,
    Italic,
    Underline,
    Strike,
    ListItem,
    BulletList,
    OrderedList,
    Subscript,
    Superscript,
    HardBreak,
    Blockquote,
    CharacterCount,
    Dropcursor.configure({
      width: 2,
      color: '#2563eb'
    }),
    HorizontalRule,

    TextAlign.configure({
      types: ['heading', 'paragraph']
    }),

    Gapcursor
  ],
  onUpdate: ({ editor }) => {
    contentResult.value = editor.getHTML()
    emit('update:modelValue', editor.getHTML())
  }
})
watchEffect(
  () => props.modelValue,
  (newValue, oldValue) => {
    const isSame = newValue === oldValue
    if (isSame) {
      return
    }

    editorInstance.value?.commands.setContent(newValue, false)
  }
)

onMounted(() => {
  setTimeout(() => (contentResult.value = editorInstance.value?.getHTML()), 250)
})

onBeforeUnmount(() => {
  editorInstance.value?.destroy()
})
const toggleModalTable = async () => {
  showAddTableDialog.value = !showAddTableDialog.value
}
</script>

<style lang="scss" scoped></style>
