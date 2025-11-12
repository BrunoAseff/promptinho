<template>
  <label class="checkbox-label">
    <input
      type="checkbox"
      :checked="modelValue"
      @change="handleChange"
      class="checkbox"
    />
    <span><slot /></span>
  </label>
</template>

<script setup lang="ts">
interface Props {
  modelValue: boolean;
}

defineProps<Props>();

const emit = defineEmits<{
  'update:modelValue': [value: boolean];
}>();

const handleChange = (event: Event) => {
  const target = event.target as HTMLInputElement;
  emit('update:modelValue', target.checked);
};
</script>

<style scoped>
.checkbox-label {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.875rem;
  color: var(--color-text-secondary);
  cursor: pointer;
  font-weight: 300;
  color: var(--color-text-primary);
}

.checkbox {
  appearance: none;
  -webkit-appearance: none;
  width: 18px;
  height: 18px;
  border: 2px solid var(--color-border-primary);
  border-radius: 4px;
  background: var(--color-bg-primary);
  cursor: pointer;
  position: relative;
  transition: all 0.15s ease;
  flex-shrink: 0;
  margin: 0;
}

.checkbox:hover {
  border-color: var(--color-border-secondary);
}

.checkbox:checked {
  background: var(--color-accent-primary);
  border-color: var(--color-accent-primary);
}

.checkbox:checked::after {
  content: '';
  position: absolute;
  left: 4px;
  top: 1px;
  width: 4px;
  height: 8px;
  border: solid white;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
}

.checkbox:focus-visible {
  outline: 2px solid var(--color-accent-primary);
  outline-offset: 2px;
}

.checkbox:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>
