This gives you model information:
```
curl http://100.106.86.84:4000/model/info -H "Authorization: Bearer abcd" -H "Content-Type: application/json" | jq
```


Want to add custom descriptions like what each model is good for?
```
model_list:
  - model_name: llama3
    litellm_params:
      model: ollama/llama3:8b-text-q5_0
      api_base: http://localhost:11434
    model_info:
      mode: chat
      description: "General local chat model for rewriting, summaries, Q&A, and light coding help."
      metadata:
        category: "general_chat"
        best_for:
          - chat
          - rewriting
          - summarization
          - light_coding

  - model_name: embed-local
    litellm_params:
      model: ollama/nomic-embed-text:latest
      api_base: http://localhost:11434
    model_info:
      mode: embedding
      description: "Local embedding model for semantic search, RAG, and similarity matching."
      metadata:
        category: "embedding"
        best_for:
          - rag
          - semantic_search
          - retrieval

  - model_name: qwen-heavy
    litellm_params:
      model: ollama/qwen2.5:32b
      api_base: http://localhost:11434
    model_info:
      mode: chat
      description: "Heavier local model for long prompts, multilingual tasks, and more complex reasoning."
      metadata:
        category: "heavy_reasoning"
        best_for:
          - long_context
          - reasoning
          - multilingual
          - document_analysis

general_settings:
  master_key: abcd

```


Running the get models info api endpoint, you'll get information enriched with your custom descriptions:
```
{
  "data": [
    {
      "model_name": "llama3",
      "litellm_params": {
        "api_base": "http://localhost:11434",
        "use_in_pass_through": false,
        "use_litellm_proxy": false,
        "merge_reasoning_content_in_choices": false,
        "model": "ollama/llama3:8b-text-q5_0"
      },
      "model_info": {
        "id": "a063abeab5e91e5721ce39f8751a93054dd799b8ab163cf12f8afc38080d7b7f",
        "db_model": false,
        "mode": "chat",
        "description": "General local chat model for rewriting, summaries, Q&A, and light coding help.",
        "metadata": {
          "category": "general_chat",
          "best_for": [
            "chat",
            "rewriting",
            "summarization",
            "light_coding"
          ]
        },
        "key": "llama3:8b-text-q5_0",
        "max_tokens": 8192,
        "max_input_tokens": 8192,
        "max_output_tokens": 8192,
        "input_cost_per_token": 0.0,
        "input_cost_per_token_flex": null,
        "input_cost_per_token_priority": null,
        "cache_creation_input_token_cost": null,
        "cache_creation_input_token_cost_above_200k_tokens": null,
        "cache_read_input_token_cost": null,
        "cache_read_input_token_cost_above_200k_tokens": null,
        "cache_read_input_token_cost_above_272k_tokens": null,
        "cache_read_input_token_cost_flex": null,
        "cache_read_input_token_cost_priority": null,
        "cache_creation_input_token_cost_above_1hr": null,
        "input_cost_per_character": null,
        "input_cost_per_token_above_128k_tokens": null,
        "input_cost_per_token_above_200k_tokens": null,
        "input_cost_per_token_above_272k_tokens": null,
        "input_cost_per_query": null,
        "input_cost_per_second": null,
        "input_cost_per_audio_token": null,
        "input_cost_per_image_token": null,
        "input_cost_per_image": null,
        "input_cost_per_audio_per_second": null,
        "input_cost_per_video_per_second": null,
        "input_cost_per_token_batches": null,
        "output_cost_per_token_batches": null,
        "output_cost_per_token": 0.0,
        "output_cost_per_token_flex": null,
        "output_cost_per_token_priority": null,
        "output_cost_per_audio_token": null,
        "output_cost_per_character": null,
        "output_cost_per_reasoning_token": null,
        "output_cost_per_token_above_128k_tokens": null,
        "output_cost_per_character_above_128k_tokens": null,
        "output_cost_per_token_above_200k_tokens": null,
        "output_cost_per_token_above_272k_tokens": null,
        "output_cost_per_second": null,
        "output_cost_per_second_1080p": null,
        "output_cost_per_video_per_second": null,
        "output_cost_per_image": null,
        "output_cost_per_image_token": null,
        "output_vector_size": null,
        "citation_cost_per_token": null,
        "tiered_pricing": null,
        "litellm_provider": "ollama",
        "supports_system_messages": null,
        "supports_response_schema": null,
        "supports_vision": null,
        "supports_function_calling": false,
        "supports_tool_choice": null,
        "supports_assistant_prefill": null,
        "supports_prompt_caching": null,
        "supports_audio_input": null,
        "supports_audio_output": null,
        "supports_pdf_input": null,
        "supports_embedding_image_input": null,
        "supports_native_streaming": null,
        "supports_native_structured_output": null,
        "supports_web_search": null,
        "supports_url_context": null,
        "supports_reasoning": null,
        "supports_none_reasoning_effort": null,
        "supports_xhigh_reasoning_effort": null,
        "supports_computer_use": null,
        "search_context_cost_per_query": null,
        "tpm": null,
        "rpm": null,
        "ocr_cost_per_page": null,
        "annotation_cost_per_page": null,
        "provider_specific_entry": null,
        "uses_embed_content": null,
        "supported_openai_params": [
          "max_tokens",
          "stream",
          "top_p",
          "temperature",
          "seed",
          "frequency_penalty",
          "stop",
          "response_format",
          "max_completion_tokens",
          "reasoning_effort"
        ]
      }
    },
    {
      "model_name": "embed-local",
      "litellm_params": {
        "api_base": "http://localhost:11434",
        "use_in_pass_through": false,
        "use_litellm_proxy": false,
        "merge_reasoning_content_in_choices": false,
        "model": "ollama/nomic-embed-text:latest"
      },
      "model_info": {
        "id": "2339cfa39b649dac6523b037167dc02e8139c7b8efa503120d0c6080ee2fbe13",
        "db_model": false,
        "mode": "embedding",
        "description": "Local embedding model for semantic search, RAG, and similarity matching.",
        "metadata": {
          "category": "embedding",
          "best_for": [
            "rag",
            "semantic_search",
            "retrieval"
          ]
        },
        "key": "nomic-embed-text:latest",
        "max_tokens": 2048,
        "max_input_tokens": 2048,
        "max_output_tokens": 2048,
        "input_cost_per_token": 0.0,
        "input_cost_per_token_flex": null,
        "input_cost_per_token_priority": null,
        "cache_creation_input_token_cost": null,
        "cache_creation_input_token_cost_above_200k_tokens": null,
        "cache_read_input_token_cost": null,
        "cache_read_input_token_cost_above_200k_tokens": null,
        "cache_read_input_token_cost_above_272k_tokens": null,
        "cache_read_input_token_cost_flex": null,
        "cache_read_input_token_cost_priority": null,
        "cache_creation_input_token_cost_above_1hr": null,
        "input_cost_per_character": null,
        "input_cost_per_token_above_128k_tokens": null,
        "input_cost_per_token_above_200k_tokens": null,
        "input_cost_per_token_above_272k_tokens": null,
        "input_cost_per_query": null,
        "input_cost_per_second": null,
        "input_cost_per_audio_token": null,
        "input_cost_per_image_token": null,
        "input_cost_per_image": null,
        "input_cost_per_audio_per_second": null,
        "input_cost_per_video_per_second": null,
        "input_cost_per_token_batches": null,
        "output_cost_per_token_batches": null,
        "output_cost_per_token": 0.0,
        "output_cost_per_token_flex": null,
        "output_cost_per_token_priority": null,
        "output_cost_per_audio_token": null,
        "output_cost_per_character": null,
        "output_cost_per_reasoning_token": null,
        "output_cost_per_token_above_128k_tokens": null,
        "output_cost_per_character_above_128k_tokens": null,
        "output_cost_per_token_above_200k_tokens": null,
        "output_cost_per_token_above_272k_tokens": null,
        "output_cost_per_second": null,
        "output_cost_per_second_1080p": null,
        "output_cost_per_video_per_second": null,
        "output_cost_per_image": null,
        "output_cost_per_image_token": null,
        "output_vector_size": null,
        "citation_cost_per_token": null,
        "tiered_pricing": null,
        "litellm_provider": "ollama",
        "supports_system_messages": null,
        "supports_response_schema": null,
        "supports_vision": null,
        "supports_function_calling": false,
        "supports_tool_choice": null,
        "supports_assistant_prefill": null,
        "supports_prompt_caching": null,
        "supports_audio_input": null,
        "supports_audio_output": null,
        "supports_pdf_input": null,
        "supports_embedding_image_input": null,
        "supports_native_streaming": null,
        "supports_native_structured_output": null,
        "supports_web_search": null,
        "supports_url_context": null,
        "supports_reasoning": null,
        "supports_none_reasoning_effort": null,
        "supports_xhigh_reasoning_effort": null,
        "supports_computer_use": null,
        "search_context_cost_per_query": null,
        "tpm": null,
        "rpm": null,
        "ocr_cost_per_page": null,
        "annotation_cost_per_page": null,
        "provider_specific_entry": null,
        "uses_embed_content": null,
        "supported_openai_params": [
          "max_tokens",
          "stream",
          "top_p",
          "temperature",
          "seed",
          "frequency_penalty",
          "stop",
          "response_format",
          "max_completion_tokens",
          "reasoning_effort"
        ]
      }
    },
    {
      "model_name": "qwen-heavy",
      "litellm_params": {
        "api_base": "http://localhost:11434",
        "use_in_pass_through": false,
        "use_litellm_proxy": false,
        "merge_reasoning_content_in_choices": false,
        "model": "ollama/qwen2.5:32b"
      },
      "model_info": {
        "id": "1c27c84725c64ff559d3e8cd666a5bb943a3e4db2fe8cb5a808071c490986863",
        "db_model": false,
        "mode": "chat",
        "description": "Heavier local model for long prompts, multilingual tasks, and more complex reasoning.",
        "metadata": {
          "category": "heavy_reasoning",
          "best_for": [
            "long_context",
            "reasoning",
            "multilingual",
            "document_analysis"
          ]
        },
        "key": "qwen2.5:32b",
        "max_tokens": 32768,
        "max_input_tokens": 32768,
        "max_output_tokens": 32768,
        "input_cost_per_token": 0.0,
        "input_cost_per_token_flex": null,
        "input_cost_per_token_priority": null,
        "cache_creation_input_token_cost": null,
        "cache_creation_input_token_cost_above_200k_tokens": null,
        "cache_read_input_token_cost": null,
        "cache_read_input_token_cost_above_200k_tokens": null,
        "cache_read_input_token_cost_above_272k_tokens": null,
        "cache_read_input_token_cost_flex": null,
        "cache_read_input_token_cost_priority": null,
        "cache_creation_input_token_cost_above_1hr": null,
        "input_cost_per_character": null,
        "input_cost_per_token_above_128k_tokens": null,
        "input_cost_per_token_above_200k_tokens": null,
        "input_cost_per_token_above_272k_tokens": null,
        "input_cost_per_query": null,
        "input_cost_per_second": null,
        "input_cost_per_audio_token": null,
        "input_cost_per_image_token": null,
        "input_cost_per_image": null,
        "input_cost_per_audio_per_second": null,
        "input_cost_per_video_per_second": null,
        "input_cost_per_token_batches": null,
        "output_cost_per_token_batches": null,
        "output_cost_per_token": 0.0,
        "output_cost_per_token_flex": null,
        "output_cost_per_token_priority": null,
        "output_cost_per_audio_token": null,
        "output_cost_per_character": null,
        "output_cost_per_reasoning_token": null,
        "output_cost_per_token_above_128k_tokens": null,
        "output_cost_per_character_above_128k_tokens": null,
        "output_cost_per_token_above_200k_tokens": null,
        "output_cost_per_token_above_272k_tokens": null,
        "output_cost_per_second": null,
        "output_cost_per_second_1080p": null,
        "output_cost_per_video_per_second": null,
        "output_cost_per_image": null,
        "output_cost_per_image_token": null,
        "output_vector_size": null,
        "citation_cost_per_token": null,
        "tiered_pricing": null,
        "litellm_provider": "ollama",
        "supports_system_messages": null,
        "supports_response_schema": null,
        "supports_vision": null,
        "supports_function_calling": true,
        "supports_tool_choice": null,
        "supports_assistant_prefill": null,
        "supports_prompt_caching": null,
        "supports_audio_input": null,
        "supports_audio_output": null,
        "supports_pdf_input": null,
        "supports_embedding_image_input": null,
        "supports_native_streaming": null,
        "supports_native_structured_output": null,
        "supports_web_search": null,
        "supports_url_context": null,
        "supports_reasoning": null,
        "supports_none_reasoning_effort": null,
        "supports_xhigh_reasoning_effort": null,
        "supports_computer_use": null,
        "search_context_cost_per_query": null,
        "tpm": null,
        "rpm": null,
        "ocr_cost_per_page": null,
        "annotation_cost_per_page": null,
        "provider_specific_entry": null,
        "uses_embed_content": null,
        "supported_openai_params": [
          "max_tokens",
          "stream",
          "top_p",
          "temperature",
          "seed",
          "frequency_penalty",
          "stop",
          "response_format",
          "max_completion_tokens",
          "reasoning_effort"
        ]
      }
    }
  ]
}

```


---

**Tip: Leverage AI**

It's suggested after you added your models to config.yaml, that you ask AI to enhance it with custom information on what each model is good for with this syntax:
```
    model_info:
      mode: chat
      description: "General local chat model for rewriting, summaries, Q&A, and light coding help."
      metadata:
        category: "general_chat"
        best_for:
          - chat
          - rewriting
          - summarization
          - light_coding
```
