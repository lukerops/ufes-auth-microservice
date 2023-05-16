import connexion
import six

from swagger_server.models.login_body import LoginBody  # noqa: E501
from swagger_server.models.new_password import NewPassword  # noqa: E501
from swagger_server.models.token import Token  # noqa: E501
from swagger_server.models.user import User  # noqa: E501
from swagger_server import util


def change_password_put(body):  # noqa: E501
    """Altera senha do usuário autenticado

     # noqa: E501

    :param body: Senhas antiga e nova do usuário
    :type body: dict | bytes

    :rtype: None
    """
    if connexion.request.is_json:
        body = NewPassword.from_dict(connexion.request.get_json())  # noqa: E501
    return 'do some magic!'


def login_post(body):  # noqa: E501
    """Realiza login e retorna token de acesso

     # noqa: E501

    :param body: Credenciais de login
    :type body: dict | bytes

    :rtype: Token
    """
    if connexion.request.is_json:
        body = LoginBody.from_dict(connexion.request.get_json())  # noqa: E501
    return 'do some magic!'


def register_post(body):  # noqa: E501
    """Registra novo usuário

     # noqa: E501

    :param body: Dados do usuário a ser registrado
    :type body: dict | bytes

    :rtype: None
    """
    if connexion.request.is_json:
        body = User.from_dict(connexion.request.get_json())  # noqa: E501
    return 'do some magic!'


def verify_token_get():  # noqa: E501
    """Verifica se o token de acesso é válido

     # noqa: E501


    :rtype: None
    """
    return 'do some magic!'
