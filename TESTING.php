class GPTPreTraining {
    private $config = [
        'vocab_size' => 50257,
        'hidden_size' => 768,
        'num_layers' => 12,
        'num_heads' => 12,
        'max_position_embeddings' => 1024
    ];

    public function getTrainingSteps(): array {
        return [
            'data_preparation' => [
                'id' => 'data-prep',
                'title' => 'Data Preparation',
                'steps' => [
                    ['id' => 'raw-data', 'name' => 'Raw Text Data'],
                    ['id' => 'tokenization', 'name' => 'Tokenization'],
                    ['id' => 'chunks', 'name' => 'Create Chunks']
                ]
            ],
            'model_architecture' => [
                'id' => 'architecture',
                'title' => 'Model Architecture',
                'steps' => [
                    ['id' => 'input-embed', 'name' => 'Input Embeddings'],
                    ['id' => 'pos-embed', 'name' => 'Positional Embeddings'],
                    [
                        'id' => 'transformer',
                        'name' => 'Transformer Layers',
                        'substeps' => [
                            ['id' => 'self-attention', 'name' => 'Self-Attention'],
                            ['id' => 'ffn', 'name' => 'Feed Forward Network']
                        ]
                    ],
                    ['id' => 'output', 'name' => 'Output Layer']
                ]
            ],
            'training' => [
                'id' => 'training',
                'title' => 'Training Process',
                'steps' => [
                    ['id' => 'forward', 'name' => 'Forward Pass'],
                    ['id' => 'loss', 'name' => 'Calculate Loss'],
                    ['id' => 'backward', 'name' => 'Backward Pass'],
                    ['id' => 'update', 'name' => 'Update Parameters']
                ]
            ],
            'optimization' => [
                'id' => 'optimization',
                'title' => 'Optimization',
                'steps' => [
                    ['id' => 'adam', 'name' => 'Adam Optimizer'],
                    ['id' => 'lr-schedule', 'name' => 'Learning Rate Scheduling'],
                    ['id' => 'grad-clip', 'name' => 'Gradient Clipping']
                ]
            ]
        ];
    }

    public function renderDiagram(): string {
        return json_encode($this->getTrainingSteps());
    }
}
