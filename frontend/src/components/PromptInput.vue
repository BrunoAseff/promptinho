<template>
  <div class="prompt-input-wrapper" :class="{ 'is-focused': isFocused }">
    <div class="prompt-header">
      <span class="prompt-label">PROMPT {{ index + 1 }}</span>
      <button
        class="remove-btn"
        :class="{ 'is-hidden': !canRemove }"
        :disabled="!canRemove"
        @click="emit('remove')"
        title="Remover este prompt"
      >
        <PhX :size="32" weight="thin" />
      </button>
    </div>

    <textarea
      :value="prompt.text"
      @input="handleInput"
      @focus="handleFocus"
      class="prompt-textarea"
      placeholder="Digite seu prompt aqui..."
      spellcheck="false"
    />

    <div class="status-bar">
      <div v-if="prompt.isLoading" class="status">
        <span class="status-text">ANALISANDO...</span>
      </div>

      <div v-else-if="prompt.error" class="status error">
        <span class="status-text">{{ prompt.error }}</span>
      </div>

      <div v-else-if="prompt.tokenData" class="token-count">
        <span class="count-label">TOKENS:</span>
        <span class="count-value">{{ prompt.tokenData.count }}</span>
      </div>
      <div class="copy-btn" @click="copyPrompt">
        <PhCopy v-if="!isCopying" :size="22" weight="thin" />
        <PhCheck v-else :size="22" weight="thin" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { Prompt } from '../types';
import { PhCopy, PhCheck, PhX } from '@phosphor-icons/vue';
import { ref } from 'vue';

interface Props {
  prompt: Prompt;
  index: number;
  isFocused: boolean;
  canRemove: boolean;
}

const props = defineProps<Props>();

const emit = defineEmits<{
  focus: [];
  'update:text': [text: string];
  remove: [];
}>();

const isCopying = ref(false);

const handleInput = (event: Event) => {
  const target = event.target as HTMLTextAreaElement;
  emit('update:text', target.value);
};

const handleFocus = () => {
  emit('focus');
};

const copyPrompt = () => {
  navigator.clipboard.writeText(props.prompt.text);
  isCopying.value = true;
  setTimeout(() => {
    isCopying.value = false;
  }, 2000);
};
</script>

<style scoped>
.prompt-input-wrapper {
  position: relative;
  border: 1px solid var(--color-border-primary);
  border-radius: 8px;
  background: var(--color-bg-primary);
  transition: all 0.2s ease;
}

.prompt-input-wrapper.is-focused {
  border-color: var(--color-accent-primary);
}

.prompt-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0.75rem 1rem;
}

.prompt-label {
  font-size: 0.8rem;
  font-weight: 300;
  color: var(--color-text-tertiary);
}

.remove-btn {
  width: 24px;
  height: 24px;
  border: none;
  background: transparent;
  color: var(--color-text-tertiary);
  font-size: 1.5rem;
  line-height: 1;
  cursor: pointer;
  border-radius: 4px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.15s ease;
}

.remove-btn:hover:not(:disabled) {
  background: var(--color-error-hover-bg);
  color: var(--color-error-text);
}

.remove-btn.is-hidden {
  opacity: 0;
  pointer-events: none;
}

.prompt-textarea {
  width: 100%;
  min-height: 150px;
  padding: 1rem;
  border: none;
  outline: none;
  font-family: 'SF Mono', Monaco, 'Cascadia Code', 'Roboto Mono', Consolas,
    monospace;
  font-size: 0.9375rem;
  line-height: 1.6;
  resize: vertical;
  background: transparent;
  color: var(--color-text-primary);
}

.prompt-textarea::placeholder {
  color: var(--color-text-tertiary);
}

.status-bar {
  height: 36px;
  display: flex;
  align-items: center;
  border-bottom-left-radius: 8px;
  border-bottom-right-radius: 8px;
}

.status {
  width: 100%;
  padding: 0 1rem;
}

.status.error {
  color: var(--color-error-text);
}

.status-text {
  font-size: 0.875rem;
  text-transform: uppercase;
  font-weight: 300;
}

.token-count {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0 1rem;
}

.count-label {
  font-size: 0.875rem;
  color: var(--color-text-primary);
  font-weight: 300;
}

.count-value {
  font-size: 0.875rem;
  font-weight: 500;
  color: var(--color-text-primary);
  font-variant-numeric: tabular-nums;
}

.copy-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  margin-left: auto;
  padding: 0 1rem;
}
</style>
