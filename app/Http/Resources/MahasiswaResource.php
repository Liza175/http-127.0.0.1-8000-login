<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MahasiswaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       // return parent::toArray($request);
       return [
        'nim' => $this->nim,
        'nama' => $this->nama,
        'jk' => $this->jk,
        'tgl_lahir' => $this->tgl_lahir,
        'jurusan' => $this->jurusan,
        'alamat' => $this->alamat,
        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at,
       ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'message' => 'Data Mahasiswa retrieved succeccfully'
        ];
    }
}
