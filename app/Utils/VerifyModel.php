<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class VerifyModel
{


    protected Model $model;
    protected array $rules = [];
    protected array $messages = [];

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Check if the resource exists
     * @param mixed $id
     * @param string $message
     * @return Model
     * @throws NotFoundHttpException
     */
    public function exists(mixed $id, $message = 'The resource does not exist')
    {
        $model = $this->model->find($id);

        if (!$model) {
            throw new NotFoundHttpException($message);
        }

        return $model;
    }

    /**
     * Check if the resource exists
     * @param mixed $id
     * @param string $message
     * @return Model
     * @throws NotFoundHttpException
     */

    public function unique($field, $value, $message = 'The resource already exists')
    {
        $model = $this->model->where($field, $value)->first();

        if ($model) {
            throw new UnprocessableEntityHttpException($message);
        }
        return $model;
    }

    /**
     * Get the model
     * @return Model
     */
    public function model(): Model
    {
        return $this->model;
    }


    /**
     * Check if the resource exists
     * @param mixed $id
     * @param string $message
     * @return Model
     */
    public function rules(array $rules)
    {
        $this->rules = $rules;
        return $this;
    }


    /**
     * Check if the resource exists
     * @param mixed $id
     * @param string $message
     * @return Model
     */
    public function messages(array $messages)
    {
        $this->messages = $messages;
        return $this;
    }


    /**
     * Validate the resource
     * @param mixed $id
     * @param string $message
     * @param string $rules
     * @return self
     * @throws UnprocessableEntityHttpException
     */
    public function validate(mixed $id, string $message = null, string $rules = null)
    {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => $rules ?: $this->rules],
            $this->messages
        )->stopOnFirstFailure(true);

        if ($validator->fails()) {
            throw new UnprocessableEntityHttpException($message ?: $validator->errors()->first());
        }

        return $this;
    }
}
