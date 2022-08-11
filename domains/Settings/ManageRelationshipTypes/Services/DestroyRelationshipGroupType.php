<?php

namespace App\Settings\ManageRelationshipTypes\Services;

use App\Interfaces\ServiceInterface;
use App\Models\RelationshipGroupType;
use App\Models\User;
use App\Services\BaseService;

class DestroyRelationshipGroupType extends BaseService implements ServiceInterface
{
    /**
     * Get the validation rules that apply to the service.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'account_id' => 'required|integer|exists:accounts,id',
            'relationship_group_type_id' => 'required|integer|exists:relationship_group_types,id',
            'author_id' => 'required|integer|exists:users,id',
        ];
    }

    /**
     * Get the permissions that apply to the user calling the service.
     *
     * @return array
     */
    public function permissions(): array
    {
        return [
            'author_must_belong_to_account',
            'author_must_be_account_administrator',
        ];
    }

    /**
     * Destroy a relationship group type.
     *
     * @param  array  $data
     */
    public function execute(array $data): void
    {
        $this->validateRules($data);

        $type = RelationshipGroupType::where('account_id', $data['account_id'])
            ->where('can_be_deleted', true)
            ->findOrFail($data['relationship_group_type_id']);

        $type->delete();
    }
}
