<?php

namespace App\Domains\Vault\ManageVaultSettings\Services;

use App\Interfaces\ServiceInterface;
use App\Models\VaultQuickFactTemplate;
use App\Services\BaseService;

class CreateQuickFactTemplate extends BaseService implements ServiceInterface
{
    private VaultQuickFactTemplate $quickFactTemplateEntry;

    /**
     * Get the validation rules that apply to the service.
     */
    public function rules(): array
    {
        return [
            'account_id' => 'required|integer|exists:accounts,id',
            'author_id' => 'required|integer|exists:users,id',
            'vault_id' => 'required|integer|exists:vaults,id',
            'label' => 'required|string|max:255',
        ];
    }

    /**
     * Get the permissions that apply to the user calling the service.
     */
    public function permissions(): array
    {
        return [
            'author_must_belong_to_account',
            'author_must_be_vault_editor',
            'vault_must_belong_to_account',
        ];
    }

    /**
     * Create a quick fact template entry.
     */
    public function execute(array $data): VaultQuickFactTemplate
    {
        $this->validateRules($data);

        // determine the new position of the quick fact template entry
        $newPosition = $this->vault->quickFactsTemplateEntries()
            ->max('position');
        $newPosition++;

        $this->quickFactTemplateEntry = VaultQuickFactTemplate::create([
            'vault_id' => $data['vault_id'],
            'label' => $data['label'],
            'position' => $newPosition,
        ]);

        return $this->quickFactTemplateEntry;
    }
}
