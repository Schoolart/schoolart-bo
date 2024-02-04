<?php

namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Model\PathItem;
use ApiPlatform\Core\OpenApi\Model\Operation;
use ApiPlatform\Core\OpenApi\Model\RequestBody;
use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;

class OpenApiFactory implements OpenApiFactoryInterface
{

    /**
     */
    function __construct(private OpenApiFactoryInterface $decorated)
    {
    }
    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);
        /** @var PathItem $path */
        foreach ($openApi->getPaths()->getPaths() as $key => $path) {
            if ($path->getGet() && $path->getGet()->getSummary() == 'hidden') {
                $openApi->getPaths()->addPath($key, $path->withGet(null));
            }
        }

        $schemas = $openApi->getComponents()->getSecuritySchemes();
        $schemas['bearerAuth'] = new \ArrayObject(
            [
                'type' => 'http',
                'scheme' => 'bearer',
                'bearerFormat' => 'JWT'
            ]
        );
        $openApi = $openApi->withSecurity([['bearerAuth' => []]]);


        //dd($this->hash->hashPassword(new User(), 'passer@123'));
        $schemas = $openApi->getComponents()->getSchemas();
        $schemas['Credentials'] = new \ArrayObject(
            [
                'type' => 'object',
                'properties' => [
                    'username' => [
                        'type' => 'string',
                        'example' => 'john@example.com',
                    ],
                    'password' => [
                        'type' => 'string',
                        'example' => '0000'
                    ]

                ]
            ]
        );
        $schemas['Token'] = new \ArrayObject(
            [
                'type' => 'object',
                'properties' => [
                    'token' => [
                        'type' => 'string',
                        'readOnly'=>true, 
                    ],
                ]
            ]
        );
        $pathItem = new PathItem(
            post: new Operation(
                operationId: 'postApiLogin',
                tags: ['Authentication'],
                security: [],
                requestBody: new RequestBody(
                    content: new \ArrayObject([
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#/components/schemas/Credentials'
                            ]
                        ]
                    ])
                ),
                responses: [
                    '200' => [
                        'description' => 'Token JWT connecté',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/Token'
                                ]
                            ]
                        ]

                    ]
                ]
            )
        );
        $openApi->getPaths()->addPath('/api/login', $pathItem);
        return $openApi;
    }
}