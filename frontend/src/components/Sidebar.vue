<template>
  <aside class="sidebar">
    <div class="sidebar-section">
      <h2 class="section-title">Algoritmo de Tokenização</h2>

      <Radio
        :model-value="algorithm"
        @update:model-value="emit('update:algorithm', $event)"
        :options="algorithmOptions"
      />
    </div>

    <div class="sidebar-section">
      <div class="section-header">
        <h2 class="section-title">Análise</h2>
        <Tabs v-model="activeTab" :tabs="analysisTabs" />
      </div>

      <div v-if="activeTab === 'visualization'" class="tab-content">
        <div class="controls">
          <Checkbox v-model="showIds"> Mostrar IDs dos tokens </Checkbox>
        </div>

        <div class="visualization-wrapper">
          <TokenVisualization
            :token-data="prompt.tokenData"
            :show-ids="showIds"
          />
        </div>
      </div>

      <div v-if="activeTab === 'metrics'" class="tab-content">
        <div class="metrics">
          <div class="metric">
            <span class="metric-label">Caracteres</span>
            <span class="metric-value">{{ prompt.text.length }}</span>
          </div>

          <div class="metric">
            <span class="metric-label">Tokens</span>
            <span class="metric-value">{{ prompt.tokenData?.count ?? 0 }}</span>
          </div>

          <div class="metric">
            <span class="metric-label">Carac. por token</span>
            <span class="metric-value">
              {{
                prompt.tokenData?.count
                  ? (prompt.text.length / prompt.tokenData.count).toFixed(2)
                  : '0'
              }}
            </span>
          </div>

          <div class="metric">
            <span class="metric-label">Palavras (aprox.)</span>
            <span class="metric-value">{{
              prompt.text.trim() ? prompt.text.trim().split(/\s+/).length : 0
            }}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="sidebar-actions">
      <button class="action-btn secondary" @click="emit('clear')">
        Limpar
      </button>
      <button
        class="action-btn primary"
        @click="emit('copy')"
        :disabled="!prompt.text"
      >
        Copiar
      </button>
    </div>
  </aside>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import TokenVisualization from './TokenVisualization.vue';
import Checkbox from './Checkbox.vue';
import Radio from './Radio.vue';
import Tabs from './Tabs.vue';
import type { Prompt, Algorithm } from '../types';
import { ALGORITHM_INFO } from '../types';
import { PhCoinVertical, PhGraph } from '@phosphor-icons/vue';

interface Props {
  prompt: Prompt;
  algorithm: Algorithm;
}

const props = defineProps<Props>();

const emit = defineEmits<{
  'update:algorithm': [algorithm: Algorithm];
  clear: [];
  copy: [];
}>();

const showIds = ref(false);
const activeTab = ref<'visualization' | 'metrics'>('visualization');

const algorithmOptions = computed(() =>
  Object.entries(ALGORITHM_INFO).map(([key, info]) => ({
    value: key,
    name: info.name,
    description: info.description,
  }))
);

const analysisTabs = [
  { value: 'visualization', label: 'TOKENS', icon: PhCoinVertical },
  { value: 'metrics', label: 'MÉTRICAS', icon: PhGraph },
];
</script>

<style scoped>
.sidebar {
  width: 450px;
  height: 100vh;
  border-left: 1px solid var(--color-border-primary);
  background: var(--color-bg-primary);
  display: flex;
  flex-direction: column;
  overflow-y: auto;
}

.sidebar-section {
  padding: 1.5rem;
  border-bottom: 1px solid var(--color-border-primary);
}

.section-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 1rem;
}

.section-title {
  font-size: 0.875rem;
  font-weight: 300;
  color: var(--color-text-primary);
  text-transform: uppercase;
  letter-spacing: 0.05em;
  margin-bottom: 0.5rem;
}

.tab-content {
  margin-top: 0.75rem;
}

.controls {
  margin-bottom: 1rem;
}

.visualization-wrapper {
  background: var(--color-bg-secondary);
  border: 1px solid var(--color-border-primary);
  border-radius: 6px;
  max-height: 400px;
  overflow-y: auto;
}

.metrics {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}

.metric {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
}

.metric-label {
  font-size: 0.75rem;
  color: var(--color-text-secondary);
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.metric-value {
  font-size: 1.5rem;
  font-weight: 400;
  color: var(--color-text-primary);
  font-variant-numeric: tabular-nums;
}

.sidebar-actions {
  margin-top: auto;
  padding: 1.5rem;
  border-top: 1px solid var(--color-border-primary);
  display: flex;
  gap: 0.75rem;
}

.action-btn {
  flex: 1;
  padding: 0.625rem 1rem;
  border: none;
  border-radius: 6px;
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.15s ease;
}

.action-btn.secondary {
  background: var(--color-bg-quaternary);
  color: var(--color-text-secondary);
}

.action-btn.secondary:hover {
  background: var(--color-border-primary);
  color: var(--color-text-primary);
}

.action-btn.primary {
  background: var(--color-accent-primary);
  color: #fff;
}

.action-btn.primary:hover {
  background: var(--color-accent-hover);
}

.action-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>
