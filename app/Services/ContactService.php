<?php
namespace App\Services;

use App\Models\Contact;
use App\Requests\ContactRequest;

class ContactService
{
    private $contactModel;

    public function __construct(Contact $contactModel)
    {
        $this->contactModel = $contactModel;
    }

    public function processContact(array $data): array
    {
        try {
            $request = new ContactRequest($data);
            
            if (!$request->validate()) {
                return [
                    'success' => false,
                    'errors' => $request->getErrors(),
                    'form_data' => $request->getFormData()
                ];
            }

            $validatedData = $request->getValidatedData();

            $contactId = $this->contactModel->create($validatedData);
            
            if ($contactId) {
                $emailSent = $this->sendNotificationEmail($validatedData);
                
                return [
                    'success' => true,
                    'contact_id' => $contactId,
                    'email_sent' => $emailSent,
                    'message' => 'Mensagem enviada com sucesso! Entraremos em contato em breve.'
                ];
            } else {
                throw new \Exception('Erro ao salvar mensagem de contato no banco de dados');
            }
            
        } catch (\Exception $e) {
            error_log('Erro no ContactService: ' . $e->getMessage());
            return [
                'success' => false,
                'errors' => ['general' => 'Erro interno do sistema. Tente novamente.'],
                'form_data' => $data
            ];
        }
    }

    private function sendNotificationEmail(array $contactData): bool
    {
        try {
            $to = 'admin@sistemaif.com'; 
            $subject = "Novo Contato: {$contactData['assunto']}";
            
            $message = "
            Nova mensagem de contato recebida:\n\n
            Nome: {$contactData['nome']}\n
            Email: {$contactData['email']}\n
            Assunto: {$contactData['assunto']}\n
            Data/Hora: {$contactData['data_envio']}\n
            IP: {$contactData['ip']}\n\n
            Mensagem:\n{$contactData['mensagem']}\n\n
            ---\n
            Sistema IF - Contato
            ";
            
            $headers = [
                'From' => 'noreply@sistemaif.com',
                'Reply-To' => $contactData['email'],
                'X-Mailer' => 'PHP/' . phpversion()
            ];
            
           
            error_log("EMAIL NOTIFICATION: " . $message);
            
    
            return true; 
            
        } catch (\Exception $e) {
            error_log('Erro ao enviar email de notificação: ' . $e->getMessage());
            return false;
        }
    }

    public function getContactById(int $id): ?array
    {
        try {
            return $this->contactModel->findById($id);
        } catch (\Exception $e) {
            error_log('Erro ao buscar contato: ' . $e->getMessage());
            return null;
        }
    }

    public function getAllContacts(): array
    {
        try {
            return $this->contactModel->findAll();
        } catch (\Exception $e) {
            error_log('Erro ao buscar contatos: ' . $e->getMessage());
            return [];
        }
    }

    public function getRecentContacts(int $limit = 10): array
    {
        try {
            return $this->contactModel->findRecent($limit);
        } catch (\Exception $e) {
            error_log('Erro ao buscar contatos recentes: ' . $e->getMessage());
            return [];
        }
    }
}
?>