export interface TokenData {
  count: number;
  tokens: number[];
  decoded_text: string[];
}

export interface Prompt {
  id: string;
  text: string;
  tokenData: TokenData | null;
  isLoading: boolean;
  error: string | null;
}

export type Algorithm = 'gpt-4o' | 'gpt-3.5-turbo';

export const ALGORITHM_INFO: Record<
  Algorithm,
  { name: string; description: string; encoding: string }
> = {
  'gpt-4o': {
    name: 'o200k_base',
    description:
      'o1, o3, o4-mini, chatgpt-4o, gpt-5, gpt-4.1, gpt-4.5, gpt-4o, gpt-oss',
    encoding: 'o200k_base',
  },
  'gpt-3.5-turbo': {
    name: 'cl100k_base',
    description: 'gpt-4, gpt-3.5-turbo',
    encoding: 'cl100k_base',
  },
};
