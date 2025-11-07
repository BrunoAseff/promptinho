<template>
  <div class="app">
    <header class="header">
      <h1 class="title">Promptinho</h1>
      <p class="subtitle">Contador e Analisador de Tokens</p>
    </header>

    <div class="main-container">
      <main class="content">
        <div class="prompts">
          <PromptInput
            v-for="(prompt, index) in prompts"
            :key="prompt.id"
            :prompt="prompt"
            :index="index"
            :is-focused="prompt.id === focusedPromptId"
            :can-remove="prompts.length > 1"
            @focus="focusedPromptId = prompt.id"
            @update:text="updateText(prompt.id, $event)"
            @remove="removePrompt(prompt.id)"
          />

          <button
            class="add-prompt"
            @click="addPrompt"
            title="Adicionar variação de prompt"
          >
            <span class="add-icon">+</span>
          </button>
        </div>
      </main>

      <Sidebar
        :prompt="focusedPrompt"
        :algorithm="selectedAlgorithm"
        @update:algorithm="onAlgorithmChange"
        @clear="clearPrompt"
        @copy="copyPrompt"
      />
    </div>
  </div>
</template>
<script setup lang="ts">
import { ref, computed } from 'vue';
import PromptInput from './components/PromptInput.vue';
import Sidebar from './components/Sidebar.vue';
import type { Prompt, Algorithm } from './types';
import { countTokens } from './api';

const prompts = ref<Prompt[]>([
  {
    id: crypto.randomUUID(),
    text: '',
    tokenData: null,
    isLoading: false,
    error: null,
  },
]);

const focusedPromptId = ref<string>(prompts.value[0].id);
const selectedAlgorithm = ref<Algorithm>('gpt-4o');

const focusedPrompt = computed(
  () =>
    prompts.value.find((prompt) => prompt.id === focusedPromptId.value) ||
    prompts.value[0]
);

const addPrompt = () => {
  const lastPrompt = prompts.value[prompts.value.length - 1];
  const newPrompt: Prompt = {
    id: crypto.randomUUID(),
    text: lastPrompt.text,
    tokenData: null,
    isLoading: false,
    error: null,
  };
  prompts.value.push(newPrompt);
  focusedPromptId.value = newPrompt.id;
  updateTokens(newPrompt.id, newPrompt.text);
};

const removePrompt = (id: string) => {
  if (prompts.value.length === 1) return;

  const index = prompts.value.findIndex((prompt) => prompt.id === id);
  prompts.value.splice(index, 1);

  if (focusedPromptId.value === id) {
    focusedPromptId.value = prompts.value[Math.max(0, index - 1)].id;
  }
};

const updateText = (id: string, text: string) => {
  const prompt = prompts.value.find((prompt) => prompt.id === id);
  if (prompt) {
    prompt.text = text;
    updateTokens(id, text);
  }
};

const updateTokens = async (id: string, text: string) => {
  const prompt = prompts.value.find((prompt) => prompt.id === id);
  if (!prompt) return;

  if (!text.trim()) {
    prompt.tokenData = null;
    prompt.error = null;
    return;
  }

  prompt.isLoading = true;
  prompt.error = null;

  try {
    prompt.tokenData = await countTokens(text, selectedAlgorithm.value);
  } catch (error) {
    prompt.error = error instanceof Error ? error.message : 'Unknown error';
    prompt.tokenData = null;
  } finally {
    prompt.isLoading = false;
  }
};

const onAlgorithmChange = (algorithm: Algorithm) => {
  selectedAlgorithm.value = algorithm;
  prompts.value.forEach((prompt: Prompt) => {
    if (prompt.text.trim()) {
      updateTokens(prompt.id, prompt.text);
    }
  });
};

const clearPrompt = () => {
  const prompt = focusedPrompt.value;
  if (prompt) {
    prompt.text = '';
    prompt.tokenData = null;
    prompt.error = null;
  }
};

const copyPrompt = async () => {
  const prompt = focusedPrompt.value;
  if (prompt && prompt.text) {
    await navigator.clipboard.writeText(prompt.text);
  }
};
</script>

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen,
    Ubuntu, Cantarell, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  background: var(--color-bg-secondary);
  color: var(--color-text-primary);
  line-height: 1.5;
}

#app {
  min-height: 100vh;
}
</style>

<style scoped>
.app {
  height: 100vh;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.header {
  padding: 1.5rem 2rem;
  border-bottom: 1px solid var(--color-border-primary);
  background: var(--color-bg-primary);
  flex-shrink: 0;
}

.title {
  font-size: 1.5rem;
  font-weight: 600;
  color: var(--color-text-primary);
  letter-spacing: -0.02em;
}

.subtitle {
  font-size: 0.875rem;
  color: var(--color-text-secondary);
  margin-top: 0.25rem;
}

.main-container {
  flex: 1;
  display: flex;
  overflow: hidden;
  min-height: 0;
}

.content {
  flex: 1;
  overflow-y: auto;
  overflow-x: hidden;
  padding: 2rem;
}

.prompts {
  max-width: 1400px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1.5rem;
  align-items: start;
}

.add-prompt {
  width: 100%;
  min-height: 245px;
  border: 2px dashed var(--color-border-secondary);
  border-radius: 8px;
  background: transparent;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
  font-size: 1rem;
  color: var(--color-text-tertiary);
}

.add-prompt:hover {
  border-color: var(--color-accent-primary);
  color: var(--color-accent-primary);
  background: var(--color-accent-bg);
}

.add-icon {
  font-size: 1.5rem;
  font-weight: 300;
}
</style>
