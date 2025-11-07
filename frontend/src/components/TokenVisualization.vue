<template>
  <div class="token-visualization">
    <div v-if="!tokenData" class="empty-state">
      Digite um texto para ver a visualização dos tokens
    </div>

    <div v-else class="tokens-container">
      <span
        v-for="(token, index) in tokens"
        :key="index"
        class="token"
        :style="{ backgroundColor: token.color }"
        :title="`Token ID: ${token.id}`"
      >
        <span class="token-text">{{ token.text }}</span>
        <span v-if="showIds" class="token-id">{{ token.id }}</span>
      </span>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import type { TokenData } from '../types';

interface Props {
  tokenData: TokenData | null;
  showIds: boolean;
}

const props = defineProps<Props>();

const colors = [
  'var(--color-token-1)',
  'var(--color-token-2)',
  'var(--color-token-3)',
  'var(--color-token-4)',
  'var(--color-token-5)',
  'var(--color-token-6)',
  'var(--color-token-7)',
  'var(--color-token-8)',
  'var(--color-token-9)',
  'var(--color-token-10)',
];

const tokens = computed(() => {
  if (!props.tokenData) return [];

  return props.tokenData.decoded_text.map((text, index) => ({
    text,
    id: props.tokenData!.tokens[index],
    color: colors[index % colors.length],
  }));
});
</script>

<style scoped>
.token-visualization {
  min-height: 100px;
}

.empty-state {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100px;
  color: var(--color-text-tertiary);
  font-size: 0.875rem;
  text-align: center;
  padding: 2rem;
}

.tokens-container {
  display: flex;
  flex-wrap: wrap;
  line-height: 1.8;
  font-family: 'SF Mono', Monaco, 'Cascadia Code', 'Roboto Mono', Consolas,
    monospace;
  font-size: 0.875rem;
  padding: 0.5rem;
}

.token {
  display: inline-flex;
  flex-direction: column;
  padding: 0.125rem 0.25rem;
  white-space: pre-wrap;
  word-break: break-all;
  cursor: default;
  border: 1px solid rgba(0, 0, 0, 0.08);
}

.token-text {
  color: var(--color-text-primary);
}

.token-id {
  font-size: 0.625rem;
  color: var(--color-text-secondary);
  margin-top: 0.125rem;
  font-variant-numeric: tabular-nums;
}
</style>
