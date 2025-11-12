<template>
  <div class="tabs">
    <button
      v-for="tab in tabs"
      :key="tab.value"
      class="tab"
      :class="{ 'is-active': modelValue === tab.value }"
      @click="$emit('update:modelValue', tab.value)"
    >
      <component v-if="tab.icon" :is="tab.icon" :size="16" weight="thin" />
      {{ tab.label }}
    </button>
  </div>
</template>

<script setup lang="ts">
import type { Component } from 'vue';

interface Tab {
  value: string;
  label: string;
  icon?: Component;
}

interface Props {
  modelValue: string;
  tabs: Tab[];
}

defineProps<Props>();

const emit = defineEmits<{
  'update:modelValue': [value: string];
}>();
</script>

<style scoped>
.tabs {
  display: flex;
  gap: 0.5rem;
  padding: 0.25rem;
  background: var(--color-bg-secondary);
  border-radius: 8px;
  border: 1px solid var(--color-border-primary);
}

.tab {
  display: flex;
  align-items: center;
  gap: 0.25rem;
  padding: 0.5rem 1rem;
  border: none;
  background: transparent;
  font-size: 0.875rem;
  font-weight: 500;
  color: var(--color-text-secondary);
  cursor: pointer;
  border-radius: 6px;
  transition: all 0.2s ease;
  white-space: nowrap;
}

.tab:hover:not(.is-active) {
  color: var(--color-text-primary);
  background: var(--color-bg-tertiary);
}

.tab.is-active {
  background: var(--color-bg-primary);
  color: var(--color-text-primary);
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}
</style>
