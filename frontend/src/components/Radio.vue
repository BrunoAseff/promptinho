<template>
  <div class="radio-group">
    <label
      v-for="option in options"
      :key="option.value"
      class="radio-option"
      :class="{ 'is-selected': modelValue === option.value }"
    >
      <input
        type="radio"
        :value="option.value"
        :checked="modelValue === option.value"
        @change="$emit('update:modelValue', option.value)"
        class="radio"
      />
      <div class="radio-content">
        <span class="radio-name">{{ option.name }}</span>
        <span class="radio-desc">{{ option.description }}</span>
      </div>
    </label>
  </div>
</template>

<script setup lang="ts">
interface RadioOption {
  value: string;
  name: string;
  description: string;
}

interface Props {
  modelValue: string;
  options: RadioOption[];
}

defineProps<Props>();

const emit = defineEmits<{
  'update:modelValue': [value: string];
}>();
</script>

<style scoped>
.radio-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.radio-option {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
  padding: 0.75rem;
  border: 1px solid var(--color-border-primary);
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.15s ease;
}

.radio-option:hover {
  border-color: var(--color-border-secondary);
  background: var(--color-bg-secondary);
}

.radio-option.is-selected {
  border-color: var(--color-accent-primary);
  background: var(--color-accent-bg);
}

.radio {
  appearance: none;
  -webkit-appearance: none;
  width: 18px;
  height: 18px;
  border: 2px solid var(--color-border-primary);
  border-radius: 50%;
  background: var(--color-bg-primary);
  cursor: pointer;
  position: relative;
  transition: all 0.15s ease;
  flex-shrink: 0;
  margin: 0;
  margin-top: 0.125rem;
}

.radio:hover {
  border-color: var(--color-border-secondary);
}

.radio:checked {
  background: var(--color-accent-primary);
  border-color: var(--color-accent-primary);
}

.radio:checked::after {
  content: '';
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: white;
}

.radio:focus-visible {
  outline: 2px solid var(--color-accent-primary);
  outline-offset: 2px;
}

.radio:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.radio-content {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
  flex: 1;
}

.radio-name {
  font-size: 0.875rem;
  font-weight: 400;
  font-family: 'SF Mono', Monaco, 'Cascadia Code', 'Roboto Mono', Consolas,
    monospace;
  color: var(--color-text-primary);
}

.radio-desc {
  font-size: 0.75rem;
  color: var(--color-text-secondary);
  line-height: 1.4;
}
</style>
