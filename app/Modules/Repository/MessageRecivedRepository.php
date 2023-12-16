<?php

namespace App\Modules\Repository;

use App\Models\Message;
use App\Models\ReceivedMsg;
use App\Modules\InterFaces\MsgRecevedRepoInterFace;
use Illuminate\Support\LazyCollection;

class MessageRecivedRepository implements MsgRecevedRepoInterFace
{
    protected $model;

    public function __construct(ReceivedMsg $msg)
    {
        $this->model = $msg;
    }

    public function model()
    {
        return $this->model;
    }
    public function all()
    {
        return LazyCollection::make(function () {
            foreach ($this->model->cursor() as $msg) {
                yield $msg;
            }
        })->chunk(200);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function pagination($request)
    {
        return $this->model->paginate($request->per_page ?? 10);
    }

    public function create($request)
    {
        return $this->model->create($request);
    }

    public function update($request, $id)
    {
        $msg = $this->model->find($id);
        return $msg->update($request);
    }

    public function delete($id)
    {
        $msg = $this->model->find($id);
        return $msg->delete();
    }
}
